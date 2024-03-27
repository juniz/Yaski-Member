<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\Mou;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\App;

class UploadMou extends Component
{
    use WithFileUploads, LivewireAlert;
    public $no_surat = '';
    public $tgl_surat = '';
    public $file_pertama;
    public $file_name;

    public function render()
    {
        return view('livewire.component.upload-mou');
    }

    public function getMou()
    {
        $data = Mou::where('user_id', auth()->user()->id)->first();
        $this->no_surat = $data->no_surat ?? '';
        $this->tgl_surat = $data->tgl_surat ?? '';
        $this->file_name = $data->file_pertama ?? '';
    }

    public function simpan()
    {
        $this->validate([
            'no_surat' => 'required',
            'tgl_surat' => 'required',
            // 'file_pertama' => 'nullable|file|mimes:pdf|max:1024'
        ], [
            'no_surat.required' => 'Nomor surat tidak boleh kosong',
            'tgl_surat.required' => 'Tanggal surat tidak boleh kosong',
            // 'file_pertama.required' => 'File pertama tidak boleh kosong',
            // 'file_pertama.file' => 'File pertama harus berupa file',
            // 'file_pertama.mimes' => 'File pertama harus berupa pdf',
            // 'file_pertama.max' => 'Ukuran file pertama maksimal 1MB'
        ]);

        try {
            if ($this->file_pertama) {
                $this->validate([
                    'file_pertama' => 'required|file|mimes:pdf|max:1024'
                ], [
                    'file_pertama.required' => 'File pertama tidak boleh kosong',
                    'file_pertama.file' => 'File pertama harus berupa file',
                    'file_pertama.mimes' => 'File pertama harus berupa pdf',
                    'file_pertama.max' => 'Ukuran file pertama maksimal 1MB'

                ]);
                $file_name = 'MOU-' . time() . '.' . $this->file_pertama->extension();
                $this->file_pertama->storeAs('public/mou', $file_name);
            } else {
                $file_name = $this->file_name;
            }
            Mou::updateOrCreate(
                ['user_id' => auth()->user()->id],
                [
                    'no_surat' => $this->no_surat,
                    'tgl_surat' => $this->tgl_surat,
                    'file_pertama' => $file_name,
                ]
            );
            $this->emit('refreshMou');
            $this->dispatchBrowserEvent('simpanMou');
            $this->alert('success', 'MOU berhasil disimpan');
        } catch (\Exception $e) {
            $this->alert('error', 'Gagal upload', [
                'position' =>  'center',
                'timeout' =>  '',
                'text' => App::environment('local') ? $e->getMessage() : 'Terjadi Kesalahan',
                'toast' =>  false,
                'confirmButtonText' => 'Tutup'
            ]);
        }
    }
}
