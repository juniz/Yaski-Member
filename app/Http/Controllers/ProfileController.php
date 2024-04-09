<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Fasyankes;
use App\Models\Paklaring;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'verified'])->except(['getKabupaten']);
    }

    public function index()
    {
        $user = auth()->user();
        $provinces = Province::all();
        $fasyankes = Fasyankes::where('user_id', $user->id)->first();
        $paklaring = Paklaring::where('user_id', $user->id)->first();
        $jenis = ['Praktik Mandiri', 'Rumah Sakit', 'Klinik', 'Puskesmas', 'Apotek'];
        $kelas = ['-', 'A', 'B', 'C', 'D', 'D Pratama'];
        return view('profile.index', compact('user', 'provinces', 'jenis', 'kelas', 'fasyankes', 'paklaring'));
    }

    public function getKabupaten($id)
    {
        $kabupaten = Province::find($id)->regencies;
        return response()->json($kabupaten);
    }

    public function updatePaklaring(Request $request, $id)
    {
        $request->validate([
            'tanggal'   => 'required',
            'dokumen'      => 'required|mimes:pdf|max:2048'
        ], [
            'tanggal.required' => 'Tanggal Paklaring tidak boleh kosong',
            'dokumen.mimes' => 'dokumen yang diupload harus berupa pdf',
            'dokumen.max' => 'Ukuran dokumen yang diupload maksimal 2MB',
            'dokumen.required' => 'Dokumen Paklaring tidak boleh kosong'
        ]);

        try {
            $paklaring = Paklaring::where('user_id', $id)->first();

            if ($request->has('dokumen')) {
                $file = $request->file('dokumen');
                $name = 'PF-' . time() . '.' . $file->getClientOriginalExtension();
                if ($paklaring) {
                    Storage::delete('public/pakelaring/' . $paklaring->file);
                }
                $file->storeAs('public/pakelaring', $name);
            }

            if ($paklaring) {
                $paklaring->tgl_pakai = $request->tanggal;
                $paklaring->file = $name;
                $paklaring->save();
            } else {
                $paklaring = new Paklaring();
                $paklaring->user_id = $id;
                $paklaring->tgl_pakai = $request->tanggal;
                $paklaring->file = $name;
                $paklaring->save();
            }
            Session::flash('message', 'Paklaring Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            return response()->json([
                'isSuccess' => true,
                'Message' => "Data Paklaring berhasil di update"
            ], 200); //
        } catch (\Exception $e) {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            return response()->json([
                'isSuccess' => false,
                'Message' => $e->getMessage() ?? "Something went wrong!"
            ], 200);
        }
    }

    public function updateFasyankes(Request $request, $id)
    {
        $request->validate([
            'kode' => 'nullable',
            'nama' => 'required',
            'jenis' => 'required',
            'kelas' => 'nullable',
            'telp' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'direktur' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:1024'
        ], [
            'nama.required' => 'Nama Fasyankes tidak boleh kosong',
            'jenis.required' => 'Jenis Fasyankes tidak boleh kosong',
            'telp.required' => 'Nomor Telepon Fasyankes tidak boleh kosong',
            'email.required' => 'Email Fasyankes tidak boleh kosong',
            'alamat.required' => 'Alamat Fasyankes tidak boleh kosong',
            'provinsi.required' => 'Provinsi Fasyankes tidak boleh kosong',
            'kabupaten.required' => 'Kabupaten Fasyankes tidak boleh kosong',
            'direktur.required' => 'Nama Direktur Fasyankes tidak boleh kosong',
            'image.image' => 'File yang diupload harus berupa gambar',
            'image.mimes' => 'File yang diupload harus berupa gambar',
            'image.max' => 'Ukuran file yang diupload maksimal 1MB'
        ]);

        try {
            // dd($request->all());
            $fasyankes = Fasyankes::where('user_id', $id)->first();

            if ($request->has('image')) {
                $image = $request->file('image');
                $name = $request->nama . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/fasyankes', $name);
                if ($fasyankes) {
                    $fasyankes->image = $name;
                }
                // if ($fasyankes->image != null) {
                //     @Storage::delete('public/fasyankes' . $fasyankes->image);
                //     $fasyankes->image = $name;
                // }
            }

            if ($fasyankes) {
                $fasyankes->kode = $request->kode ?? '';
                $fasyankes->nama = $request->nama;
                $fasyankes->jenis = $request->jenis;
                $fasyankes->kelas = $request->kelas;
                $fasyankes->telp = $request->telp;
                $fasyankes->email = $request->email;
                $fasyankes->alamat = $request->alamat;
                $fasyankes->provinsi_id = $request->provinsi ?? $fasyankes->provinsi_id;
                $fasyankes->kabupaten_id = $request->kabupaten ?? $fasyankes->kabupaten_id;
                $fasyankes->direktur = $request->direktur;
                $fasyankes->save();
            } else {
                $fasyankes = new Fasyankes();
                $fasyankes->user_id = $id;
                $fasyankes->kode = $request->kode ?? '';
                $fasyankes->nama = $request->nama;
                $fasyankes->jenis = $request->jenis;
                $fasyankes->kelas = $request->kelas ?? '';
                $fasyankes->telp = $request->telp;
                $fasyankes->email = $request->email;
                $fasyankes->alamat = $request->alamat;
                $fasyankes->provinsi_id = $request->provinsi;
                $fasyankes->kabupaten_id = $request->kabupaten;
                $fasyankes->direktur = $request->direktur;
                $fasyankes->image = $name ?? null;
                $fasyankes->save();
            }
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            return response()->json([
                'isSuccess' => true,
                'Message' => "Data Fasyankes berhasil di update"
            ], 200); //
        } catch (\Exception $e) {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            return response()->json([
                'isSuccess' => false,
                'Message' => $request->all()
            ], 200);
        }
    }
}
