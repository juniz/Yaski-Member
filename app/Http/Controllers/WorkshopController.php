<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use App\Models\Workshop;
use App\Models\WorkshopSetting;
use App\Services\CertificateGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workshops = Workshop::all();
        return view('workshops.index', compact('workshops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('workshops.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'nama' => 'required',
                'deskripsi' => 'required',
                'kuota' => 'required',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'lokasi' => 'required',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'required|date',
            ],
            [
                'nama.required' => 'Nama tidak boleh kosong',
                'deskripsi.required' => 'Deskripsi tidak boleh kosong',
                'kuota.required' => 'Kuota tidak boleh kosong',
                'gambar.required' => 'File tidak boleh kosong',
                'gambar.image' => 'File harus berupa gambar',
                'gambar.mimes' => 'File harus berupa gambar',
                'lokasi.required' => 'Lokasi tidak boleh kosong',
                'tgl_mulai.required' => 'Tanggal mulai tidak boleh kosong',
                'tgl_selesai.required' => 'Tanggal selesai tidak boleh kosong',
            ]
        );

        try {
            if (request()->has('gambar')) {
                $image = request()->file('gambar');
                $imageName = $request->nama . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/workshop', $imageName);
            }

            $workshop = new Workshop();
            $workshop->nama = $request->nama;
            $workshop->slug = Str::slug($request->nama);
            $workshop->deskripsi = $request->deskripsi;
            $workshop->kuota = $request->kuota;
            $workshop->gambar = $imageName;
            $workshop->lokasi = $request->lokasi;
            $workshop->tgl_mulai = $request->tgl_mulai;
            $workshop->tgl_selesai = $request->tgl_selesai;
            $workshop->save();

            return redirect()->to('/list-workshop')->with(['message' => 'Workshop berhasil ditambahkan', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage() ?? 'Terjadi kesalahan', 'type' => 'danger']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function show(Workshop $workshop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function edit(Workshop $workshop)
    {
        return view('workshops.edit', compact('workshop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $workshop)
    {
        $this->validate(
            $request,
            [
                'nama' => 'required',
                'deskripsi' => 'required',
                'kuota' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'tor' => 'nullable|mimes:pdf',
                'lokasi' => 'required',
                'tgl_sampai' => 'required|date',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'required|date',
            ],
            [
                'nama.required' => 'Nama tidak boleh kosong',
                'deskripsi.required' => 'Deskripsi tidak boleh kosong',
                'kuota.required' => 'Kuota tidak boleh kosong',
                'gambar.image' => 'File harus berupa gambar',
                'gambar.mimes' => 'File harus berupa gambar',
                'tor.mimes' => 'File harus berupa pdf',
                'lokasi.required' => 'Lokasi tidak boleh kosong',
                'tgl_sampai.required' => 'Tanggal sampai tidak boleh kosong',
                'tgl_mulai.required' => 'Tanggal mulai tidak boleh kosong',
                'tgl_selesai.required' => 'Tanggal selesai tidak boleh kosong',
            ]
        );

        try {
            $imageName = null;
            if (request()->has('gambar')) {
                $image = request()->file('gambar');
                $imageName = $request->nama . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/workshop', $imageName);
            }

            $torName = null;
            if (request()->has('tor')) {
                $tor = request()->file('tor');
                $torName = $request->nama . '-tor-' . time() . '.' . $tor->getClientOriginalExtension();
                $tor->storeAs('public/workshop', $torName);
            }

            $workshop = Workshop::find($workshop);
            $workshop->nama = $request->nama;
            $workshop->slug = Str::slug($request->nama);
            $workshop->deskripsi = $request->deskripsi;
            $workshop->kuota = $request->kuota;
            $workshop->gambar = $imageName ?? $workshop->gambar;
            $workshop->tor = $torName ?? $workshop->tor;
            $workshop->lokasi = $request->lokasi;
            $workshop->tgl_sampai = $request->tgl_sampai;
            $workshop->tgl_mulai = $request->tgl_mulai;
            $workshop->tgl_selesai = $request->tgl_selesai;
            $workshop->save();

            return redirect()->to('/list-workshop')->with(['message' => 'Workshop berhasil dirubah', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage() ?? 'Terjadi kesalahan', 'type' => 'danger']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workshop $workshop)
    {
        try {
            $workshop->delete();
            $prevImage = public_path('/images/workshops/' . $workshop->image);
            if (file_exists($prevImage)) {
                unlink($prevImage);
            }
            return redirect()->route('workshops.index')->with(['message' => 'Workshop berhasil dihapus', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage() ?? 'Terjadi kesalahan', 'type' => 'danger']);
        }
    }

    public function openSetting($id)
    {
        $setting = WorkshopSetting::where('workshop_id', $id)->first();
        $workshop = Workshop::find($id);
        return view('workshops.setting', compact('id', 'setting', 'workshop'));
    }

    public function simpanSetting(Request $request, $id)
    {
        $this->validate($request, [
            'deskripsi' => 'nullable',
            'file_template' => 'nullable|image|max:5120',
            'file_template_belakang' => 'nullable|image|max:5120',
            'nama_x' => 'required|integer',
            'nama_y' => 'required|integer',
            'nama_font_size' => 'required|integer|min:8|max:120',
            'nama_color' => 'required|string|max:7',
            'no_sertifikat_x' => 'required|integer',
            'no_sertifikat_y' => 'required|integer',
            'no_sertifikat_font_size' => 'required|integer|min:8|max:120',
            'no_sertifikat_color' => 'required|string|max:7',
            'instansi_x' => 'required|integer',
            'instansi_y' => 'required|integer',
            'instansi_font_size' => 'required|integer|min:8|max:120',
            'instansi_color' => 'required|string|max:7',
            'qr_x' => 'required|integer',
            'qr_y' => 'required|integer',
            'qr_size' => 'required|integer|min:50|max:500',
        ], [
            'file_template.image' => 'File harus berupa gambar',
            'file_template.max' => 'Ukuran file maksimal 5MB',
            'file_template_belakang.image' => 'File harus berupa gambar',
            'file_template_belakang.max' => 'Ukuran file maksimal 5MB',
        ]);

        try {
            $templateName = null;
            if ($request->hasFile('file_template')) {
                $template = $request->file('file_template');
                $templateName = 'template-' . time() . '.' . $template->getClientOriginalExtension();
                $template->storeAs('public/workshop/template/' . $id, $templateName);
            }
            $templateBackName = null;
            if ($request->hasFile('file_template_belakang')) {
                $templateBack = $request->file('file_template_belakang');
                $templateBackName = 'template-back-' . time() . '.' . $templateBack->getClientOriginalExtension();
                $templateBack->storeAs('public/workshop/template/' . $id, $templateBackName);
            }

            $data = [
                'deskripsi' => $request->deskripsi ?? '',
                'nama_x' => $request->nama_x,
                'nama_y' => $request->nama_y,
                'nama_font_size' => $request->nama_font_size,
                'nama_color' => $request->nama_color,
                'no_sertifikat_x' => $request->no_sertifikat_x,
                'no_sertifikat_y' => $request->no_sertifikat_y,
                'no_sertifikat_font_size' => $request->no_sertifikat_font_size,
                'no_sertifikat_color' => $request->no_sertifikat_color,
                'instansi_x' => $request->instansi_x,
                'instansi_y' => $request->instansi_y,
                'instansi_font_size' => $request->instansi_font_size,
                'instansi_color' => $request->instansi_color,
                'nama_enabled' => $request->has('nama_enabled') ? 1 : 0,
                'no_sertifikat_enabled' => $request->has('no_sertifikat_enabled') ? 1 : 0,
                'instansi_enabled' => $request->has('instansi_enabled') ? 1 : 0,
                'qr_x' => $request->qr_x,
                'qr_y' => $request->qr_y,
                'qr_size' => $request->qr_size,
                'qr_enabled' => $request->has('qr_enabled') ? 1 : 0,
            ];

            if ($templateName) {
                $data['file_template'] = $templateName;
            }
            if ($templateBackName) {
                $data['file_template_belakang'] = $templateBackName;
            }

            WorkshopSetting::updateOrCreate(
                ['workshop_id' => $id],
                $data
            );

            return redirect()->back()->with(['message' => 'Setting sertifikat berhasil disimpan', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage() ?? 'Terjadi kesalahan', 'type' => 'danger']);
        }
    }

    public function generateSertifikat($id)
    {
        try {
            $service = new CertificateGeneratorService();
            $result = $service->generateBulk($id);

            $message = "Generate selesai: {$result['success']} berhasil";
            if ($result['failed'] > 0) {
                $message .= ", {$result['failed']} gagal";
            }
            if ($result['skipped'] > 0) {
                $message .= ", {$result['skipped']} sudah ada";
            }

            return redirect()->back()->with(['message' => $message, 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage() ?? 'Terjadi kesalahan', 'type' => 'danger']);
        }
    }

    public function regenerateSertifikat($id)
    {
        try {
            $service = new CertificateGeneratorService();
            $result = $service->regenerateBulk($id);

            $message = "Regenerate selesai: {$result['success']} berhasil";
            if ($result['failed'] > 0) {
                $message .= ", {$result['failed']} gagal";
            }

            return redirect()->back()->with(['message' => $message, 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage() ?? 'Terjadi kesalahan', 'type' => 'danger']);
        }
    }

    public function cekValidasi($id)
    {
        $sertifikat = Sertifikat::with(['peserta.transaction', 'workshop'])->find($id);
        return view('workshops.validasi', compact('sertifikat'));
    }

    public function downloadSertifikatBulkPdf($id)
    {
        $workshop = Workshop::findOrFail($id);
        $sertifikats = Sertifikat::where('workshop_id', $id)
            ->whereNotNull('file_sertifikat')
            ->orderBy('id', 'asc')
            ->get();

        if ($sertifikats->isEmpty()) {
            return redirect()->back()->with(['message' => 'Belum ada sertifikat yang di-generate', 'type' => 'warning']);
        }

        // Initialize FPDF
        $pdf = new \FPDF();
        $pagesAdded = 0;

        foreach ($sertifikats as $s) {
            $filePath = storage_path('app/public/sertifikat/' . $id . '/' . $s->file_sertifikat);

            if (file_exists($filePath)) {
                // Get image dimensions
                $size = getimagesize($filePath);
                if (!$size || empty($size[0]) || empty($size[1])) {
                    continue;
                }
                $width = $size[0];
                $height = $size[1];

                // Convert pixels to mm (assuming 96 DPI)
                $wMm = $width * 0.264583;
                $hMm = $height * 0.264583;

                // Add page with custom size
                $orientation = ($wMm > $hMm) ? 'L' : 'P';
                $pdf->AddPage($orientation, [$wMm, $hMm]);
                $pdf->Image($filePath, 0, 0, $wMm, $hMm);
                $pagesAdded++;

                // Add back page if exists
                if ($s->file_sertifikat_belakang) {
                    $backPath = storage_path('app/public/sertifikat/' . $id . '/' . $s->file_sertifikat_belakang);
                    if (file_exists($backPath)) {
                        $backSize = getimagesize($backPath);
                        if ($backSize && !empty($backSize[0]) && !empty($backSize[1])) {
                            $wBackMm = $backSize[0] * 0.264583;
                            $hBackMm = $backSize[1] * 0.264583;
                            $backOrientation = ($wBackMm > $hBackMm) ? 'L' : 'P';
                            $pdf->AddPage($backOrientation, [$wBackMm, $hBackMm]);
                            $pdf->Image($backPath, 0, 0, $wBackMm, $hBackMm);
                            $pagesAdded++;
                        }
                    }
                }
            }
        }

        if ($pagesAdded === 0) {
            return redirect()->back()->with(['message' => 'File sertifikat tidak valid atau tidak ditemukan untuk digabungkan', 'type' => 'warning']);
        }

        return $pdf->Output('D', 'Semua_Sertifikat_' . \Illuminate\Support\Str::slug($workshop->nama) . '.pdf');
    }

    public function previewSertifikat($id, CertificateGeneratorService $generator)
    {
        $workshop = Workshop::findOrFail($id);
        $setting = WorkshopSetting::where('workshop_id', $id)->first();

        if (!$setting || !$setting->file_template) {
            return redirect()->back()->with(['message' => 'Template belum disetting', 'type' => 'danger']);
        }

        // Create dummy certificate object
        $dummySertifikat = new Sertifikat();
        $dummySertifikat->id = 'preview-id';
        $dummySertifikat->nama = 'Nama Peserta Contoh';
        $dummySertifikat->no_sertifikat = '2026/YASKI/04/001';
        $dummySertifikat->instansi = 'RS Contoh Instansi';
        $dummySertifikat->workshop_id = $id;

        // 1. Generate front image with dummy data
        $frontImage = $generator->generate($dummySertifikat, true);
        if (!$frontImage) {
            return redirect()->back()->with(['message' => 'Gagal generate preview depan', 'type' => 'danger']);
        }

        // Save front image to temp file for FPDF
        $tempFront = storage_path('app/public/temp_preview_front_' . time() . '.png');
        imagepng($frontImage, $tempFront);
        imagedestroy($frontImage);

        // 2. Prepare FPDF
        $pdf = new \FPDF();

        // Add Front Page
        $sizeFront = getimagesize($tempFront);
        $wMm = $sizeFront[0] * 0.264583;
        $hMm = $sizeFront[1] * 0.264583;
        $orientation = ($wMm > $hMm) ? 'L' : 'P';
        $pdf->AddPage($orientation, [$wMm, $hMm]);
        $pdf->Image($tempFront, 0, 0, $wMm, $hMm);

        // Add Back Page if exists
        if ($setting->file_template_belakang) {
            $backPath = storage_path('app/public/workshop/template/' . $id . '/' . $setting->file_template_belakang);
            if (file_exists($backPath)) {
                $sizeBack = getimagesize($backPath);
                $wBack = $sizeBack[0] * 0.264583;
                $hBack = $sizeBack[1] * 0.264583;
                $pdf->AddPage($orientation, [$wBack, $hBack]);
                $pdf->Image($backPath, 0, 0, $wBack, $hBack);
            }
        }

        // Cleanup temp file
        if (file_exists($tempFront)) unlink($tempFront);

        // Output as PDF Inline
        if (ob_get_length()) ob_end_clean();
        return $pdf->Output('I', 'Preview_Sertifikat.pdf');
    }

    public function hapusTemplate($id, $type)
    {
        try {
            $setting = WorkshopSetting::where('workshop_id', $id)->firstOrFail();
            $field = ($type === 'depan') ? 'file_template' : 'file_template_belakang';
            $fileName = $setting->$field;

            if ($fileName) {
                $filePath = 'public/workshop/template/' . $id . '/' . $fileName;
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
                $setting->$field = null;
                $setting->save();
            }

            return redirect()->back()->with(['message' => 'Template ' . $type . ' berhasil dihapus', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage() ?? 'Gagal menghapus template', 'type' => 'danger']);
        }
    }

    public function storeMaterial(Request $request, $id)
    {
        $this->validate($request, [
            'materi_title' => 'required|string|max:255',
            'materi_type' => 'required|in:file,link',
            'materi_file' => 'nullable|file|max:20480', // Max 20MB
            'materi_link' => 'nullable|url',
        ]);

        try {
            $material = new \App\Models\WorkshopMaterial();
            $material->workshop_id = $id;
            $material->title = $request->materi_title;
            $material->type = $request->materi_type;

            if ($request->materi_type === 'file' && $request->hasFile('materi_file')) {
                $file = $request->file('materi_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/workshop/material/' . $id, $fileName);
                $material->file_path = $fileName;
            } elseif ($request->materi_type === 'link') {
                $material->link_url = $request->materi_link;
            }

            $material->save();

            return redirect()->back()->with(['message' => 'Materi berhasil ditambahkan', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage() ?? 'Gagal menambahkan materi', 'type' => 'danger']);
        }
    }

    public function destroyMaterial($id)
    {
        try {
            $material = \App\Models\WorkshopMaterial::findOrFail($id);
            if ($material->type === 'file' && $material->file_path) {
                $filePath = 'public/workshop/material/' . $material->workshop_id . '/' . $material->file_path;
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }
            $material->delete();

            return redirect()->back()->with(['message' => 'Materi berhasil dihapus', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage() ?? 'Gagal menghapus materi', 'type' => 'danger']);
        }
    }
}
