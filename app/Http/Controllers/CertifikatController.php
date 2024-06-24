<?php

namespace App\Http\Controllers;

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

            return redirect()->back()->with('type', 'success')->with('message', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', App::environment('local') ? $e->getMessage() : 'Terjadi kesalahan')->with('type', 'danger');
        }
    }

    public function index($nama)
    {
        // $outputfile = public_path('certifikat.pdf');
        // $this->fillPDF(storage_path('app/public/templates/sertifikat/template2.pdf'), $outputfile, $nama);

        // return response()->file($outputfile);
        // return view('prints.labels.peserta', compact('nama'));
        // $qr = QrCode::size(250)
        //     ->format('png')
        //     ->merge('assets/images/logo.png', 0.3, true)
        //     ->style('dot')
        //     ->eye('circle')
        //     ->gradient(255, 0, 0, 0, 0, 255, 'diagonal')
        //     ->margin(1)
        //     ->errorCorrection('M')
        //     ->generate('83745837hfdyeurf');
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
