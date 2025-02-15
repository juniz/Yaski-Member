<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use App\Models\Workshop;
use App\Models\WorkshopSetting;
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
        return view('workshops.setting', compact('id'));
    }

    public function simpanSetting(Request $request, $id)
    {
        $this->validate($request, [
            'deskripsi' => 'required',
            'file_template' => 'required|image|max:2048',
        ], [
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
            'file_template.required' => 'File template tidak boleh kosong',
            'file_template.image' => 'File harus berupa gambar',
        ]);

        try {
            $templateName = null;
            if (request()->has('file_template')) {
                $template = request()->file('file_template');
                $templateName = $template->getClientOriginalName();
                $template->storeAs('public/workshop/template/' . $id, $templateName);
            }
            WorkshopSetting::updateOrCreate(
                ['workshop_id' => $id],
                [
                    'deskripsi' => $request->deskripsi,
                    'file_template' => $templateName,
                ]
            );

            return redirect()->back()->with(['message' => 'Setting berhasil disimpan', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage() ?? 'Terjadi kesalahan', 'type' => 'danger']);
        }
    }

    public function cekValidasi($id)
    {
        $sertifikat = Sertifikat::find($id);
        // dd($sertifikat);
        return view('workshops.validasi', compact('sertifikat'));
    }
}
