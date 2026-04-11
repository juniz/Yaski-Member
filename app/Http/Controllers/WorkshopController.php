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
        ]);

        try {
            $templateName = null;
            if ($request->hasFile('file_template')) {
                $template = $request->file('file_template');
                $templateName = 'template-' . time() . '.' . $template->getClientOriginalExtension();
                $template->storeAs('public/workshop/template/' . $id, $templateName);
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
                'qr_x' => $request->qr_x,
                'qr_y' => $request->qr_y,
                'qr_size' => $request->qr_size,
                'qr_enabled' => $request->has('qr_enabled') ? 1 : 0,
            ];

            if ($templateName) {
                $data['file_template'] = $templateName;
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
            ->orderBy('no_urut', 'asc')
            ->get();

        if ($sertifikats->isEmpty()) {
            return redirect()->back()->with(['message' => 'Belum ada sertifikat yang di-generate', 'type' => 'warning']);
        }

        // Initialize FPDF
        // We'll use a dynamic page size based on the first image found
        $pdf = new \FPDF();

        foreach ($sertifikats as $s) {
            $filePath = storage_path('app/public/sertifikat/' . $id . '/' . $s->file_sertifikat);

            if (file_exists($filePath)) {
                // Get image dimensions
                $size = getimagesize($filePath);
                $width = $size[0];
                $height = $size[1];

                // Convert pixels to mm (assuming 96 DPI)
                $wMm = $width * 0.264583;
                $hMm = $height * 0.264583;

                // Add page with custom size
                $orientation = ($wMm > $hMm) ? 'L' : 'P';
                $pdf->AddPage($orientation, [$wMm, $hMm]);
                $pdf->Image($filePath, 0, 0, $wMm, $hMm);
            }
        }

        return $pdf->Output('D', 'Semua_Sertifikat_' . \Illuminate\Support\Str::slug($workshop->nama) . '.pdf');
    }
}
