<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KwitansiController extends Controller
{
    public function index()
    {
        return redirect()->route('workshop.index');
    }

    public function workshop($id)
    {
        return view('workshops.kwitansi', ['id' => $id]);
    }

    public function cetak($id)
    {
        $peserta = Peserta::with(['transaction.workshop'])->findOrFail($id);
        $data = $this->buildData($peserta);

        return view('prints.kwitansi.peserta', [
            'logo' => $this->logoDataUri(),
            'qr' => $this->qrCode(route('kwitansi.validasi', $peserta->id)),
            'data' => $data,
            'print' => true,
        ]);
    }

    public function downloadWorkshop($id)
    {
        $pesertas = $this->getWorkshopReceiptsQuery($id)->get();

        if ($pesertas->isEmpty()) {
            return redirect()->back()->with([
                'type' => 'warning',
                'message' => 'Belum ada kwitansi dengan status dibayar untuk workshop ini.',
            ]);
        }

        $logo = $this->logoDataUri();
        $receipts = $pesertas->map(function (Peserta $peserta) {
            return [
                'data' => $this->buildData($peserta),
                'qr' => $this->qrCodeImage(route('kwitansi.validasi', $peserta->id)),
            ];
        });

        $workshopName = $receipts->first()['data']['workshop'] ?? 'workshop';
        $filename = 'Kwitansi-' . Str::slug($workshopName) . '.pdf';

        return Pdf::loadView('prints.kwitansi.bulk', [
            'logo' => $logo,
            'receipts' => $receipts,
        ])
            ->setPaper([0, 0, 595.28, 419.53])
            ->download($filename);
    }

    public function startBulkDownloadProgress($id)
    {
        $pesertas = $this->getWorkshopReceiptsQuery($id)->get(['peserta.id']);

        if ($pesertas->isEmpty()) {
            return response()->json([
                'message' => 'Belum ada kwitansi dengan status dibayar untuk workshop ini.',
            ], 422);
        }

        $token = Str::uuid()->toString();
        $state = [
            'workshop_id' => (int) $id,
            'token' => $token,
            'peserta_ids' => $pesertas->pluck('id')->all(),
            'receipts' => [],
            'total' => $pesertas->count(),
            'processed' => 0,
            'failed' => 0,
            'completed' => false,
            'download_ready' => false,
            'download_url' => null,
            'message' => 'Menyiapkan data kwitansi...',
        ];

        Cache::put($this->bulkKwitansiDownloadKey($id), $state, now()->addHours(2));

        return response()->json($this->formatBulkKwitansiDownloadProgress($state));
    }

    public function processBulkDownloadProgress($id)
    {
        $cacheKey = $this->bulkKwitansiDownloadKey($id);
        $state = Cache::get($cacheKey);

        if (!$state) {
            return response()->json([
                'message' => 'Progress download kwitansi tidak ditemukan. Silakan mulai ulang prosesnya.',
            ], 404);
        }

        if (!empty($state['completed'])) {
            return response()->json($this->formatBulkKwitansiDownloadProgress($state));
        }

        $chunkSize = 10;
        $remainingIds = $state['peserta_ids'] ?? [];
        $currentBatch = array_splice($remainingIds, 0, $chunkSize);

        foreach ($currentBatch as $pesertaId) {
            try {
                $peserta = Peserta::with(['transaction.workshop'])->find($pesertaId);
                if (!$peserta) {
                    $state['processed']++;
                    $state['failed']++;
                    continue;
                }

                $state['receipts'][] = [
                    'data' => $this->buildData($peserta),
                    'qr' => $this->qrCodeImage(route('kwitansi.validasi', $peserta->id)),
                ];
                $state['processed']++;
            } catch (\Throwable $e) {
                $state['processed']++;
                $state['failed']++;
                Log::error('Gagal memproses kwitansi bulk', [
                    'workshop_id' => $id,
                    'peserta_id' => $pesertaId,
                    'message' => $e->getMessage(),
                ]);
            }
        }

        $state['peserta_ids'] = $remainingIds;

        if (empty($remainingIds)) {
            try {
                $logo = $this->logoDataUri();
                $receipts = $state['receipts'] ?? [];

                if (empty($receipts)) {
                    throw new \RuntimeException('Tidak ada data kwitansi yang valid untuk dibuat PDF');
                }

                $workshopName = $receipts[0]['data']['workshop'] ?? 'workshop';
                $pdfPath = storage_path('app/temp-kwitansi-' . $state['token'] . '.pdf');

                file_put_contents($pdfPath, Pdf::loadView('prints.kwitansi.bulk', [
                    'logo' => $logo,
                    'receipts' => $receipts,
                ])->setPaper([0, 0, 595.28, 419.53])->output());

                $state['completed'] = true;
                $state['download_ready'] = true;
                $state['pdf_path'] = $pdfPath;
                $state['filename'] = 'Kwitansi-' . Str::slug($workshopName) . '.pdf';
                $state['download_url'] = route('workshop.kwitansi.download-ready', [
                    'id' => $id,
                    'token' => $state['token'],
                ]);
                $state['message'] = 'PDF kwitansi siap diunduh';
            } catch (\Throwable $e) {
                Log::error('Gagal finalisasi PDF kwitansi bulk', [
                    'workshop_id' => $id,
                    'message' => $e->getMessage(),
                ]);

                $state['completed'] = true;
                $state['download_ready'] = false;
                $state['message'] = 'Gagal membuat PDF kwitansi';
            }
        } else {
            $state['message'] = 'Sedang menyiapkan data kwitansi...';
        }

        Cache::put($cacheKey, $state, now()->addHours(2));

        return response()->json($this->formatBulkKwitansiDownloadProgress($state));
    }

    public function downloadPreparedWorkshop($id, $token)
    {
        $cacheKey = $this->bulkKwitansiDownloadKey($id);
        $state = Cache::get($cacheKey);

        if (!$state || ($state['token'] ?? null) !== $token || empty($state['download_ready']) || empty($state['pdf_path'])) {
            return redirect()->back()->with([
                'type' => 'warning',
                'message' => 'File PDF kwitansi tidak ditemukan atau sudah kedaluwarsa.',
            ]);
        }

        $pdfPath = $state['pdf_path'];
        if (!file_exists($pdfPath)) {
            Cache::forget($cacheKey);

            return redirect()->back()->with([
                'type' => 'warning',
                'message' => 'File PDF kwitansi tidak ditemukan di server.',
            ]);
        }

        Cache::forget($cacheKey);

        return response()->download($pdfPath, $state['filename'] ?? ('Kwitansi-workshop-' . $id . '.pdf'), [
            'Content-Type' => 'application/pdf',
        ])->deleteFileAfterSend(true);
    }

    public function validasi($id)
    {
        $peserta = Peserta::with(['transaction.workshop'])->find($id);
        $data = null;

        if ($peserta && $peserta->transaction && $peserta->transaction->workshop) {
            $data = $this->buildData($peserta);
        }

        return view('workshops.validasi-kwitansi', [
            'peserta' => $peserta,
            'data' => $data,
        ]);
    }

    private function buildData(Peserta $peserta): array
    {
        $transaction = $peserta->transaction;
        $workshop = $transaction ? $transaction->workshop : null;
        $harga = (int) ($peserta->harga ?? 0);
        $sertifikat = null;

        if ($transaction) {
            $sertifikat = \App\Models\Sertifikat::where('workshop_id', $transaction->workshop_id)
                ->where('peserta_id', $peserta->id)
                ->first();
        }

        Carbon::setLocale('id');

        return [
            'no_urut_sertifikat' => $sertifikat->no_urut ?? null,
            'no_kwitansi' => 'KWT/' . date('Y') . '/' . str_pad($workshop ? $workshop->id : 0, 3, '0', STR_PAD_LEFT) . '/' . str_pad($peserta->id, 5, '0', STR_PAD_LEFT),
            'order_id' => $transaction ? ($transaction->order_id ?? '-') : '-',
            'nama' => $peserta->nama,
            'penerima' => $transaction && $transaction->nama_rs ? $transaction->nama_rs : $peserta->nama,
            'terbilang' => $this->terbilang($harga),
            'harga' => $harga,
            'workshop' => $this->plainText($workshop ? $workshop->nama : '-'),
            'paket' => $this->plainText($peserta->paket),
            'tgl_mulai' => $workshop && $workshop->tgl_mulai ? Carbon::parse($workshop->tgl_mulai)->translatedFormat('d F Y') : '-',
            'tgl_selesai' => $workshop && ($workshop->tgl_selesai ?: $workshop->tgl_sampai) ? Carbon::parse($workshop->tgl_selesai ?: $workshop->tgl_sampai)->translatedFormat('d F Y') : '-',
            'lokasi' => $this->plainText($workshop ? ($workshop->lokasi ?? '-') : '-'),
            'status' => $transaction ? ($transaction->stts ?? '-') : '-',
            'validasi_url' => route('kwitansi.validasi', $peserta->id),
        ];
    }

    private function plainText($value): string
    {
        $value = html_entity_decode((string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $value = preg_replace('/<\s*br\s*\/?\s*>/i', ' ', $value);
        $value = strip_tags($value);

        return (string) Str::of($value)->replaceMatches('/\s+/', ' ')->trim();
    }

    private function logoDataUri(): string
    {
        $imagePath = public_path('assets/images/logo.png');
        if (!file_exists($imagePath)) {
            return '';
        }

        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
        $imageData = file_get_contents($imagePath);

        return 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);
    }

    private function qrCode(string $url): string
    {
        return QrCode::format('svg')
            ->size(180)
            ->margin(2)
            ->errorCorrection('H')
            ->generate($url);
    }

    private function qrCodeImage(string $url): string
    {
        if (!function_exists('imagecreatetruecolor')) {
            $svg = QrCode::format('svg')
                ->size(260)
                ->margin(2)
                ->errorCorrection('H')
                ->generate($url);

            return 'data:image/svg+xml;base64,' . base64_encode($svg);
        }

        $size = 260;
        $qrCode = Encoder::encode($url, ErrorCorrectionLevel::H());
        $matrix = $qrCode->getMatrix();
        $matrixWidth = $matrix->getWidth();
        $moduleSize = max(1, (int) floor(($size - 24) / $matrixWidth));
        $actualSize = $moduleSize * $matrixWidth;
        $border = (int) floor(($size - $actualSize) / 2);

        $image = imagecreatetruecolor($size, $size);
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        imagefill($image, 0, 0, $white);

        for ($row = 0; $row < $matrixWidth; $row++) {
            for ($col = 0; $col < $matrixWidth; $col++) {
                if ($matrix->get($col, $row) === 1) {
                    imagefilledrectangle(
                        $image,
                        $border + ($col * $moduleSize),
                        $border + ($row * $moduleSize),
                        $border + (($col + 1) * $moduleSize) - 1,
                        $border + (($row + 1) * $moduleSize) - 1,
                        $black
                    );
                }
            }
        }

        $logoPath = public_path('assets/images/logo.png');
        if (file_exists($logoPath)) {
            $logo = @imagecreatefrompng($logoPath);
            if ($logo) {
                $logoSize = 42;
                $logoX = (int) (($size - $logoSize) / 2);
                $logoY = (int) (($size - $logoSize) / 2);
                imagefilledrectangle($image, $logoX - 6, $logoY - 6, $logoX + $logoSize + 6, $logoY + $logoSize + 6, $white);
                imagecopyresampled($image, $logo, $logoX, $logoY, 0, 0, $logoSize, $logoSize, imagesx($logo), imagesy($logo));
                imagedestroy($logo);
            }
        }

        ob_start();
        imagepng($image);
        $png = ob_get_clean();
        imagedestroy($image);

        return 'data:image/png;base64,' . base64_encode($png);
    }

    private function penyebut($nilai): string
    {
        $nilai = abs((int) $nilai);
        $huruf = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

        if ($nilai < 12) {
            return ' ' . $huruf[$nilai];
        }
        if ($nilai < 20) {
            return $this->penyebut($nilai - 10) . ' belas';
        }
        if ($nilai < 100) {
            return $this->penyebut($nilai / 10) . ' puluh' . $this->penyebut($nilai % 10);
        }
        if ($nilai < 200) {
            return ' seratus' . $this->penyebut($nilai - 100);
        }
        if ($nilai < 1000) {
            return $this->penyebut($nilai / 100) . ' ratus' . $this->penyebut($nilai % 100);
        }
        if ($nilai < 2000) {
            return ' seribu' . $this->penyebut($nilai - 1000);
        }
        if ($nilai < 1000000) {
            return $this->penyebut($nilai / 1000) . ' ribu' . $this->penyebut($nilai % 1000);
        }
        if ($nilai < 1000000000) {
            return $this->penyebut($nilai / 1000000) . ' juta' . $this->penyebut($nilai % 1000000);
        }
        if ($nilai < 1000000000000) {
            return $this->penyebut($nilai / 1000000000) . ' milyar' . $this->penyebut(fmod($nilai, 1000000000));
        }

        return $this->penyebut($nilai / 1000000000000) . ' trilyun' . $this->penyebut(fmod($nilai, 1000000000000));
    }

    private function terbilang($nilai): string
    {
        $hasil = $nilai < 0 ? 'minus ' . trim($this->penyebut($nilai)) : trim($this->penyebut($nilai));

        return (string) Str::of($hasil)->squish();
    }

    private function getWorkshopReceiptsQuery($workshopId)
    {
        return Peserta::with(['transaction.workshop'])
            ->whereHas('transaction', function ($query) use ($workshopId) {
                $query->where('workshop_id', $workshopId)
                    ->where('stts', 'dibayar');
            })
            ->join('transaction', 'transaction.id', '=', 'peserta.transaction_id')
            ->leftJoin('sertifikat', function ($join) {
                $join->on('sertifikat.peserta_id', '=', 'peserta.id')
                    ->on('sertifikat.workshop_id', '=', 'transaction.workshop_id');
            })
            ->orderByRaw('CASE WHEN sertifikat.no_urut IS NULL OR sertifikat.no_urut = "" THEN 1 ELSE 0 END ASC')
            ->orderByRaw('CAST(sertifikat.no_urut AS UNSIGNED) ASC')
            ->orderBy('transaction.order_id', 'asc')
            ->select('peserta.*');
    }

    private function bulkKwitansiDownloadKey($workshopId)
    {
        $userId = Auth::id() ?? 'guest';

        return 'bulk_kwitansi_download_' . $userId . '_' . $workshopId;
    }

    private function formatBulkKwitansiDownloadProgress(array $state)
    {
        $total = max(1, (int) ($state['total'] ?? 0));
        $processed = (int) ($state['processed'] ?? 0);
        $percent = (int) floor(($processed / $total) * 100);

        return [
            'total' => (int) ($state['total'] ?? 0),
            'processed' => $processed,
            'failed' => (int) ($state['failed'] ?? 0),
            'completed' => (bool) ($state['completed'] ?? false),
            'download_ready' => (bool) ($state['download_ready'] ?? false),
            'download_url' => $state['download_url'] ?? null,
            'percent' => min(100, $percent),
            'message' => $state['message'] ?? '',
        ];
    }
}
