<?php

namespace App\Http\Livewire\Component;

use App\Models\InhouseTrainingRequest;
use Illuminate\Support\Facades\App;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadInhouseTraining extends Component
{
    use WithFileUploads, LivewireAlert;

    public $nama_kegiatan = '';
    public $no_surat = '';
    public $tgl_surat = '';
    public $file;

    public function render()
    {
        return view('livewire.component.upload-inhouse-training');
    }

    public function simpan()
    {
        $this->validate([
            'nama_kegiatan' => 'required',
            'no_surat' => 'required',
            'tgl_surat' => 'required',
            'file' => 'required|file|mimes:pdf|max:2048',
        ], [
            'nama_kegiatan.required' => 'Nama kegiatan tidak boleh kosong',
            'no_surat.required' => 'Nomor surat tidak boleh kosong',
            'tgl_surat.required' => 'Tanggal surat tidak boleh kosong',
            'file.required' => 'Surat permintaan tidak boleh kosong',
            'file.file' => 'Surat permintaan harus berupa file',
            'file.mimes' => 'Surat permintaan harus berupa PDF',
            'file.max' => 'Ukuran surat permintaan maksimal 2MB',
        ]);

        try {
            $fileName = 'INHOUSE-' . time() . '.' . $this->file->extension();
            $this->file->storeAs('public/inhouse-training', $fileName);

            InhouseTrainingRequest::create([
                'user_id' => auth()->id(),
                'nama_kegiatan' => $this->nama_kegiatan,
                'no_surat' => $this->no_surat,
                'tgl_surat' => $this->tgl_surat,
                'file' => $fileName,
                'stts' => 'proses',
                'alasan' => null,
            ]);

            $this->reset(['nama_kegiatan', 'no_surat', 'tgl_surat', 'file']);
            $this->emit('refreshInhouseTraining');
            $this->alert('success', 'Permintaan inhouse training berhasil disimpan');
        } catch (\Throwable $th) {
            $this->alert('error', App::environment('local') ? $th->getMessage() : 'Terjadi kesalahan pada server', [
                'position' => 'center',
                'toast' => false,
            ]);
        }
    }
}
