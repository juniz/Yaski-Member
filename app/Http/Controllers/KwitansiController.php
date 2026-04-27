<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
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
        $pesertas = Peserta::with(['transaction.workshop'])
            ->whereHas('transaction', function ($query) use ($id) {
                $query->where('workshop_id', $id)
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
            ->select('peserta.*')
            ->get();

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
}
