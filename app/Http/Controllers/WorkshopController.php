<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use App\Models\Workshop;
use App\Models\WorkshopMaterial;
use App\Models\WorkshopSetting;
use App\Services\CertificateGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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
        $workshop = Workshop::with('materials')->find($id);
        return view('workshops.setting', compact('id', 'setting', 'workshop'));
    }

    public function publicMaterials(Workshop $workshop)
    {
        $workshop->load(['materials' => function ($query) {
            $query->latest();
        }]);

        return view('workshops.materials-public', compact('workshop'));
    }

    public function openMaterial(WorkshopMaterial $material)
    {
        if ($material->type === 'link') {
            abort_if(empty($material->link_url), 404);

            return redirect()->away($material->link_url);
        }

        $path = $this->materialStoragePath($material);
        abort_unless(Storage::exists($path), 404);

        return response()->file(Storage::path($path));
    }

    public function downloadMaterial(WorkshopMaterial $material)
    {
        if ($material->type === 'link') {
            abort_if(empty($material->link_url), 404);

            return redirect()->away($material->link_url);
        }

        $path = $this->materialStoragePath($material);
        abort_unless(Storage::exists($path), 404);

        return Storage::download($path, $this->materialDownloadName($material));
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

    public function startBulkSertifikatProgress($id, Request $request)
    {
        $request->validate([
            'mode' => 'required|in:generate,regenerate',
        ]);

        $mode = $request->mode;
        $workshop = Workshop::findOrFail($id);
        $sertifikats = Sertifikat::where('workshop_id', $id)
            ->orderBy('id', 'asc')
            ->get(['id', 'file_sertifikat']);

        $pendingIds = [];
        $skipped = 0;

        foreach ($sertifikats as $sertifikat) {
            if ($mode === 'generate' && $sertifikat->file_sertifikat) {
                $filePath = storage_path('app/public/sertifikat/' . $id . '/' . $sertifikat->file_sertifikat);
                if (file_exists($filePath)) {
                    $skipped++;
                    continue;
                }
            }

            $pendingIds[] = $sertifikat->id;
        }

        $state = [
            'workshop_id' => (int) $id,
            'workshop_nama' => $workshop->nama,
            'mode' => $mode,
            'total' => $sertifikats->count(),
            'pending_ids' => $pendingIds,
            'processed' => 0,
            'success' => 0,
            'failed' => 0,
            'skipped' => $skipped,
            'completed' => count($pendingIds) === 0,
            'message' => count($pendingIds) === 0
                ? 'Tidak ada sertifikat yang perlu diproses'
                : 'Proses bulk sertifikat dimulai',
        ];

        Cache::put($this->bulkSertifikatProgressKey($id, $mode), $state, now()->addHours(2));

        return response()->json($this->formatBulkSertifikatProgress($state));
    }

    public function processBulkSertifikatProgress($id, Request $request)
    {
        $request->validate([
            'mode' => 'required|in:generate,regenerate',
        ]);

        $mode = $request->mode;
        $cacheKey = $this->bulkSertifikatProgressKey($id, $mode);
        $state = Cache::get($cacheKey);

        if (!$state) {
            return response()->json([
                'message' => 'Progress bulk sertifikat tidak ditemukan. Silakan mulai ulang prosesnya.',
            ], 404);
        }

        if (!empty($state['completed'])) {
            return response()->json($this->formatBulkSertifikatProgress($state));
        }

        $service = new CertificateGeneratorService();
        $chunkSize = 5;
        $pendingIds = $state['pending_ids'] ?? [];
        $currentBatch = array_splice($pendingIds, 0, $chunkSize);

        foreach ($currentBatch as $sertifikatId) {
            try {
                $result = $service->generate($sertifikatId);
                if ($result) {
                    $state['success']++;
                } else {
                    $state['failed']++;
                }
            } catch (\Throwable $e) {
                $state['failed']++;
                Log::error('Gagal memproses progress bulk sertifikat', [
                    'workshop_id' => $id,
                    'mode' => $mode,
                    'sertifikat_id' => $sertifikatId,
                    'message' => $e->getMessage(),
                ]);
            }

            $state['processed']++;
        }

        $state['pending_ids'] = $pendingIds;
        $state['completed'] = count($pendingIds) === 0;
        $state['message'] = $state['completed']
            ? 'Proses bulk sertifikat selesai'
            : 'Sedang memproses sertifikat...';

        Cache::put($cacheKey, $state, now()->addHours(2));

        return response()->json($this->formatBulkSertifikatProgress($state));
    }

    public function startBulkSertifikatDownloadProgress($id)
    {
        $workshop = Workshop::findOrFail($id);
        $pages = $this->buildBulkSertifikatPageSources($id);

        if (empty($pages)) {
            return response()->json([
                'message' => 'Belum ada sertifikat yang di-generate',
            ], 422);
        }

        $token = Str::uuid()->toString();
        $state = [
            'workshop_id' => (int) $id,
            'workshop_nama' => $workshop->nama,
            'token' => $token,
            'total' => count($pages),
            'processed' => 0,
            'failed' => 0,
            'pages' => $pages,
            'prepared_pages' => [],
            'temp_files' => [],
            'completed' => false,
            'download_ready' => false,
            'download_url' => null,
            'message' => 'Menyiapkan file sertifikat untuk PDF gabungan...',
        ];

        Cache::put($this->bulkSertifikatDownloadKey($id), $state, now()->addHours(2));

        return response()->json($this->formatBulkSertifikatDownloadProgress($state));
    }

    public function processBulkSertifikatDownloadProgress($id)
    {
        $cacheKey = $this->bulkSertifikatDownloadKey($id);
        $state = Cache::get($cacheKey);

        if (!$state) {
            return response()->json([
                'message' => 'Progress download PDF gabungan tidak ditemukan. Silakan mulai ulang prosesnya.',
            ], 404);
        }

        if (!empty($state['completed'])) {
            return response()->json($this->formatBulkSertifikatDownloadProgress($state));
        }

        $chunkSize = 6;
        $remainingPages = $state['pages'] ?? [];
        $currentBatch = array_splice($remainingPages, 0, $chunkSize);

        foreach ($currentBatch as $sourcePath) {
            try {
                $preparedPath = $this->prepareImageForBulkPdf($sourcePath, $state['temp_files']);
                if ($preparedPath) {
                    $state['prepared_pages'][] = $preparedPath;
                    $state['processed']++;
                } else {
                    $state['processed']++;
                    $state['failed']++;
                }
            } catch (\Throwable $e) {
                $state['processed']++;
                $state['failed']++;
                Log::error('Gagal menyiapkan halaman bulk PDF sertifikat', [
                    'workshop_id' => $id,
                    'source_path' => $sourcePath,
                    'message' => $e->getMessage(),
                ]);
            }
        }

        $state['pages'] = $remainingPages;

        if (empty($remainingPages)) {
            $downloadToken = $state['token'];
            $pdfPath = storage_path('app/temp-bulk-sertifikat-' . $downloadToken . '.pdf');

            try {
                @set_time_limit(0);
                $pdf = new \FPDF();
                $pagesAdded = 0;

                foreach ($state['prepared_pages'] as $preparedPath) {
                    if (!file_exists($preparedPath)) {
                        continue;
                    }

                    $size = @getimagesize($preparedPath);
                    if (!$size || empty($size[0]) || empty($size[1])) {
                        continue;
                    }

                    $wMm = $size[0] * 0.264583;
                    $hMm = $size[1] * 0.264583;
                    $orientation = ($wMm > $hMm) ? 'L' : 'P';

                    $pdf->AddPage($orientation, [$wMm, $hMm]);
                    $pdf->Image($preparedPath, 0, 0, $wMm, $hMm);
                    $pagesAdded++;
                }

                if ($pagesAdded === 0) {
                    throw new \RuntimeException('Tidak ada halaman valid untuk dibuatkan PDF');
                }

                $pdf->Output('F', $pdfPath);

                foreach ($state['temp_files'] as $tempFile) {
                    if (is_string($tempFile) && file_exists($tempFile)) {
                        @unlink($tempFile);
                    }
                }

                $state['prepared_pages'] = [];
                $state['temp_files'] = [];
                $state['completed'] = true;
                $state['download_ready'] = true;
                $state['pdf_path'] = $pdfPath;
                $state['download_url'] = route('workshop.download-bulk-pdf.ready', [
                    'id' => $id,
                    'token' => $downloadToken,
                ]);
                $state['message'] = 'PDF gabungan siap diunduh';
            } catch (\Throwable $e) {
                Log::error('Gagal finalisasi bulk PDF sertifikat', [
                    'workshop_id' => $id,
                    'message' => $e->getMessage(),
                ]);

                foreach ($state['temp_files'] as $tempFile) {
                    if (is_string($tempFile) && file_exists($tempFile)) {
                        @unlink($tempFile);
                    }
                }

                $state['prepared_pages'] = [];
                $state['temp_files'] = [];
                $state['completed'] = true;
                $state['download_ready'] = false;
                $state['message'] = 'Gagal membuat PDF gabungan sertifikat';
            }
        } else {
            $state['message'] = 'Sedang menyiapkan halaman PDF gabungan...';
        }

        Cache::put($cacheKey, $state, now()->addHours(2));

        return response()->json($this->formatBulkSertifikatDownloadProgress($state));
    }

    public function downloadPreparedBulkSertifikatPdf($id, $token)
    {
        $cacheKey = $this->bulkSertifikatDownloadKey($id);
        $state = Cache::get($cacheKey);

        if (!$state || ($state['token'] ?? null) !== $token || empty($state['download_ready']) || empty($state['pdf_path'])) {
            return redirect()->back()->with(['message' => 'File PDF gabungan tidak ditemukan atau sudah kedaluwarsa', 'type' => 'warning']);
        }

        $pdfPath = $state['pdf_path'];
        if (!file_exists($pdfPath)) {
            Cache::forget($cacheKey);

            return redirect()->back()->with(['message' => 'File PDF gabungan tidak ditemukan di server', 'type' => 'warning']);
        }

        Cache::forget($cacheKey);

        return response()->download($pdfPath, 'Semua_Sertifikat_' . Str::slug($state['workshop_nama'] ?? ('workshop-' . $id)) . '.pdf', [
            'Content-Type' => 'application/pdf',
        ])->deleteFileAfterSend(true);
    }

    public function cekValidasi($id)
    {
        $sertifikat = Sertifikat::with(['peserta.transaction', 'workshop'])->find($id);
        return view('workshops.validasi', compact('sertifikat'));
    }

    public function downloadSertifikatBulkPdf($id)
    {
        $tempFiles = [];

        try {
            @set_time_limit(0);

            $workshop = Workshop::findOrFail($id);
            $pages = $this->buildBulkSertifikatPageSources($id);

            if (empty($pages)) {
                return redirect()->back()->with(['message' => 'Belum ada sertifikat yang di-generate', 'type' => 'warning']);
            }

            $pdf = new \FPDF();
            $pagesAdded = 0;

            foreach ($pages as $pagePath) {
                $preparedFrontPath = $this->prepareImageForBulkPdf($pagePath, $tempFiles);
                $size = $preparedFrontPath ? getimagesize($preparedFrontPath) : false;
                if (!$size || empty($size[0]) || empty($size[1])) {
                    continue;
                }

                $wMm = $size[0] * 0.264583;
                $hMm = $size[1] * 0.264583;
                $orientation = ($wMm > $hMm) ? 'L' : 'P';

                $pdf->AddPage($orientation, [$wMm, $hMm]);
                $pdf->Image($preparedFrontPath, 0, 0, $wMm, $hMm);
                $pagesAdded++;
            }

            if ($pagesAdded === 0) {
                return redirect()->back()->with(['message' => 'File sertifikat tidak valid atau tidak ditemukan untuk digabungkan', 'type' => 'warning']);
            }

            $downloadName = 'Semua_Sertifikat_' . Str::slug($workshop->nama) . '.pdf';
            if (ob_get_length()) {
                ob_end_clean();
            }

            return response($pdf->Output('S', $downloadName))
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $downloadName . '"');
        } catch (\Throwable $e) {
            Log::error('Gagal download bulk sertifikat PDF', [
                'workshop_id' => $id,
                'message' => $e->getMessage(),
            ]);

            return redirect()->back()->with(['message' => 'Gagal membuat PDF gabungan sertifikat', 'type' => 'danger']);
        } finally {
            foreach ($tempFiles as $tempFile) {
                if (is_string($tempFile) && file_exists($tempFile)) {
                    @unlink($tempFile);
                }
            }
        }
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
            'materi_file' => 'required_if:materi_type,file|nullable|file|max:30720', // Max 30MB
            'materi_link' => 'required_if:materi_type,link|nullable|url',
        ], [
            'materi_title.required' => 'Judul materi wajib diisi.',
            'materi_type.required' => 'Tipe materi wajib dipilih.',
            'materi_type.in' => 'Tipe materi tidak valid.',
            'materi_file.required_if' => 'File materi wajib dipilih.',
            'materi_file.file' => 'Materi harus berupa file yang valid.',
            'materi_file.max' => 'Ukuran file materi maksimal 30MB.',
            'materi_link.required_if' => 'URL link materi wajib diisi.',
            'materi_link.url' => 'URL link materi harus valid, contoh: https://example.com/materi.',
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

    private function bulkSertifikatProgressKey($workshopId, $mode)
    {
        $userId = Auth::id() ?? 'guest';

        return 'bulk_sertifikat_progress_' . $userId . '_' . $workshopId . '_' . $mode;
    }

    private function materialStoragePath(WorkshopMaterial $material)
    {
        return 'public/workshop/material/' . $material->workshop_id . '/' . basename($material->file_path);
    }

    private function materialDownloadName(WorkshopMaterial $material)
    {
        $extension = pathinfo($material->file_path, PATHINFO_EXTENSION);
        $name = Str::slug($material->title ?: 'materi-workshop');

        return $extension ? $name . '.' . $extension : $name;
    }

    private function bulkSertifikatDownloadKey($workshopId)
    {
        $userId = Auth::id() ?? 'guest';

        return 'bulk_sertifikat_download_' . $userId . '_' . $workshopId;
    }

    private function buildBulkSertifikatPageSources($workshopId)
    {
        $sertifikats = Sertifikat::where('workshop_id', $workshopId)
            ->whereNotNull('file_sertifikat')
            ->orderBy('id', 'asc')
            ->get(['file_sertifikat', 'file_sertifikat_belakang']);

        $pages = [];

        foreach ($sertifikats as $sertifikat) {
            $frontPath = storage_path('app/public/sertifikat/' . $workshopId . '/' . $sertifikat->file_sertifikat);
            if (file_exists($frontPath)) {
                $pages[] = $frontPath;
            }
        }

        if (empty($pages)) {
            return [];
        }

        $setting = WorkshopSetting::where('workshop_id', $workshopId)->first();
        $frontTemplatePath = null;
        $backTemplatePath = null;

        if ($setting && $setting->file_template) {
            $candidateFrontPath = storage_path('app/public/workshop/template/' . $workshopId . '/' . $setting->file_template);
            if (file_exists($candidateFrontPath)) {
                $frontTemplatePath = $candidateFrontPath;
            }
        }

        if ($setting && $setting->file_template_belakang) {
            $candidateBackPath = storage_path('app/public/workshop/template/' . $workshopId . '/' . $setting->file_template_belakang);
            if (file_exists($candidateBackPath)) {
                $backTemplatePath = $candidateBackPath;
            }
        }

        if (!$backTemplatePath) {
            foreach ($sertifikats as $sertifikat) {
                if (!$sertifikat->file_sertifikat_belakang) {
                    continue;
                }

                $candidateBackPath = storage_path('app/public/sertifikat/' . $workshopId . '/' . $sertifikat->file_sertifikat_belakang);
                if (file_exists($candidateBackPath)) {
                    $backTemplatePath = $candidateBackPath;
                    break;
                }
            }
        }

        if ($frontTemplatePath) {
            for ($i = 0; $i < 5; $i++) {
                $pages[] = $frontTemplatePath;
            }
        }

        if ($backTemplatePath) {
            $pages[] = $backTemplatePath;
        }

        return $pages;
    }

    private function prepareImageForBulkPdf($sourcePath, array &$tempFiles)
    {
        $imageInfo = @getimagesize($sourcePath);
        if (!$imageInfo || empty($imageInfo['mime'])) {
            return null;
        }

        if ($imageInfo['mime'] === 'image/jpeg') {
            return $sourcePath;
        }

        switch ($imageInfo['mime']) {
            case 'image/png':
                $image = @imagecreatefrompng($sourcePath);
                break;
            case 'image/webp':
                $image = function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($sourcePath) : false;
                break;
            default:
                $image = false;
                break;
        }

        if (!$image) {
            return null;
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $canvas = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);
        imagecopy($canvas, $image, 0, 0, 0, 0, $width, $height);

        $tempPath = storage_path('app/temp-bulk-cert-' . uniqid('', true) . '.jpg');
        imagejpeg($canvas, $tempPath, 85);

        imagedestroy($canvas);
        imagedestroy($image);

        $tempFiles[] = $tempPath;

        return $tempPath;
    }

    private function formatBulkSertifikatProgress(array $state)
    {
        $processedAll = ($state['processed'] ?? 0) + ($state['skipped'] ?? 0);
        $total = max(1, (int) ($state['total'] ?? 0));
        $percent = (int) floor(($processedAll / $total) * 100);

        return [
            'mode' => $state['mode'] ?? 'generate',
            'total' => (int) ($state['total'] ?? 0),
            'processed' => (int) ($state['processed'] ?? 0),
            'processed_all' => $processedAll,
            'success' => (int) ($state['success'] ?? 0),
            'failed' => (int) ($state['failed'] ?? 0),
            'skipped' => (int) ($state['skipped'] ?? 0),
            'pending' => count($state['pending_ids'] ?? []),
            'completed' => (bool) ($state['completed'] ?? false),
            'percent' => min(100, $percent),
            'message' => $state['message'] ?? '',
        ];
    }

    private function formatBulkSertifikatDownloadProgress(array $state)
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
