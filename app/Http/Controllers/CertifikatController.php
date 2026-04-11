<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use App\Services\CertificateGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use setasign\Fpdi\Fpdi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;


class CertifikatController extends Controller
{
    public function formSertifikat($id)
    {
        $sertifikat = \App\Models\Sertifikat::find($id);
        return view('sertifikat.index', compact('sertifikat', 'id'));
    }

    public function simpanSertifikat($id, Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'instansi' => 'required',
        ], [
            'nama.required' => 'Nama harus diisi',
            'instansi.required' => 'Instansi harus diisi',
        ]);
        try {
            $sertifikat = \App\Models\Sertifikat::find($id);
            $sertifikat->nama = $request->nama;
            $sertifikat->instansi = $request->instansi;
            $sertifikat->save();

            // Auto-generate sertifikat image setelah data disimpan
            $service = new CertificateGeneratorService();
            $generated = $service->generate($id);

            $message = 'Data berhasil disimpan';
            if ($generated) {
                $message .= ' dan sertifikat berhasil di-generate';
            }

            return redirect()->back()->with('type', 'success')->with('message', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('message', App::environment('local') ? $e->getMessage() : 'Terjadi kesalahan')->with('type', 'danger');
        }
    }

    public function previewSertifikat($id)
    {
        $sertifikat = Sertifikat::with('workshop')->find($id);
        if (!$sertifikat) {
            abort(404, 'Sertifikat tidak ditemukan');
        }

        $filePath = storage_path('app/public/sertifikat/' . $sertifikat->workshop_id . '/' . $sertifikat->file_sertifikat);

        if (!$sertifikat->file_sertifikat || !file_exists($filePath)) {
            // Try to generate on the fly
            $service = new CertificateGeneratorService();
            $generated = $service->generate($id);
            if ($generated) {
                $filePath = storage_path('app/public/sertifikat/' . $sertifikat->workshop_id . '/' . $generated);
            } else {
                abort(404, 'File sertifikat tidak ditemukan. Pastikan template sudah diupload di setting workshop.');
            }
        }

        return response()->file($filePath, [
            'Content-Type' => 'image/png',
        ]);
    }

    public function previewSertifikatBack($id)
    {
        $sertifikat = Sertifikat::find($id);
        if (!$sertifikat || !$sertifikat->file_sertifikat_belakang) {
            abort(404, 'File sertifikat belakang tidak ditemukan');
        }

        $filePath = storage_path('app/public/sertifikat/' . $sertifikat->workshop_id . '/' . $sertifikat->file_sertifikat_belakang);

        if (!file_exists($filePath)) {
            abort(404, 'File sertifikat belakang tidak ditemukan di storage');
        }

        return response()->file($filePath, [
            'Content-Type' => 'image/png',
        ]);
    }

    public function downloadSertifikat($id)
    {
        $sertifikat = Sertifikat::with(['workshop', 'peserta'])->find($id);
        if (!$sertifikat) {
            abort(404, 'Sertifikat tidak ditemukan');
        }

        // 1. Ensure front side is generated
        $filePath = storage_path('app/public/sertifikat/' . $sertifikat->workshop_id . '/' . $sertifikat->file_sertifikat);
        if (!$sertifikat->file_sertifikat || !file_exists($filePath)) {
            $service = new CertificateGeneratorService();
            $generated = $service->generate($id);
            if ($generated) {
                $filePath = storage_path('app/public/sertifikat/' . $sertifikat->workshop_id . '/' . $generated);
            } else {
                abort(404, 'Gagal generate file sertifikat.');
            }
        }

        // 2. Generate PDF
        $pdf = new \FPDF();
        
        // Add Front Page
        $size = getimagesize($filePath);
        $wMm = $size[0] * 0.264583;
        $hMm = $size[1] * 0.264583;
        $orientation = ($wMm > $hMm) ? 'L' : 'P';
        $pdf->AddPage($orientation, [$wMm, $hMm]);
        $pdf->Image($filePath, 0, 0, $wMm, $hMm);

        // Add Back Page if exists
        if ($sertifikat->file_sertifikat_belakang) {
            $backPath = storage_path('app/public/sertifikat/' . $sertifikat->workshop_id . '/' . $sertifikat->file_sertifikat_belakang);
            if (file_exists($backPath)) {
                $sizeBack = getimagesize($backPath);
                $wBack = $sizeBack[0] * 0.264583;
                $hBack = $sizeBack[1] * 0.264583;
                $pdf->AddPage($orientation, [$wBack, $hBack]);
                $pdf->Image($backPath, 0, 0, $wBack, $hBack);
            }
        }

        $downloadName = 'Sertifikat-' . \Str::slug($sertifikat->nama ?? $sertifikat->peserta->nama ?? 'peserta') . '.pdf';
        
        if (ob_get_length()) ob_end_clean();
        return response($pdf->Output('S', $downloadName))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $downloadName . '"');
    }

    public function index($nama)
    {
        $pdf = PDF::loadView('prints.labels.peserta', compact('nama'));
        return $pdf->stream('certifikat.pdf');
    }

    public function fillPDF($file, $outputfile, $nama)
    {
        $fpdi = new Fpdi();
        $fpdi->setSourceFile($file);
        $template = $fpdi->importPage(1);
        $size = $fpdi->getTemplateSize($template);
        $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
        $fpdi->useTemplate($template);
        $top = 165;
        $fontSize = 0;
        if (strlen($nama) > 20) {
            $fontSize = 40;
        } else {
            $fontSize = 56;
        }
        $fpdi->SetFont('Arial', 'B', $fontSize);
        $fpdi->SetTextColor(25, 26, 25);
        $fpdi->Cell(0, $top, $nama, 0, 1, 'C');
        // $fpdi->Text($left, $top, $nama);

        return $fpdi->Output($outputfile, 'I');
    }
}
