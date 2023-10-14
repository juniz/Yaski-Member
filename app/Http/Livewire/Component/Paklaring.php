<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\Paklaring as ModelsPaklaring;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Paklaring extends Component
{
    use WithFileUploads, LivewireAlert;
    public $no_surat, $tgl_pakai, $file, $paklaring;
    protected $listeners = ['refreshPaklaring' => 'getPaklaring'];

    public function mount()
    {
        $this->getPaklaring();
        if ($this->paklaring) {
            $this->dispatchBrowserEvent('pengajuanPaklaring');
        }
    }

    public function render()
    {
        return view('livewire.component.paklaring');
    }

    public function getPaklaring()
    {
        $this->paklaring = ModelsPaklaring::where('user_id', auth()->user()->id)->first();
    }

    // public function simpan()
    // {
    //     $this->validate([
    //         'no_surat' => 'required',
    //         'tgl_pakai' => 'required',
    //         'file' => 'required|file|mimes:pdf|max:1024'
    //     ], [
    //         'no_surat.required' => 'Nomor surat tidak boleh kosong',
    //         'tgl_pakai.required' => 'Tanggal pakai tidak boleh kosong',
    //         'file.required' => 'File paklaring tidak boleh kosong',
    //         'file.file' => 'File paklaring harus berupa file',
    //         'file.mimes' => 'File paklaring harus berupa pdf',
    //         'file.max' => 'Ukuran file paklaring maksimal 1MB'
    //     ]);

    //     try {
    //         $file_name = 'PF-' . time() . '.' . $this->file->extension();
    //         $this->file->storeAs('public/pakelaring', $file_name);
    //         if ($this->paklaring->file) {
    //             unlink(storage_path('app/public/pakelaring/' . $this->paklaring->file));
    //         }
    //         if ($this->pakalaring) {
    //             $this->paklaring->update([
    //                 'no_surat' => $this->no_surat,
    //                 'tgl_pakai' => $this->tgl_pakai,
    //                 'file' => $file_name,
    //                 'stts' => 'proses'
    //             ]);
    //         } else {
    //             Paklaring::create([
    //                 'user_id' => auth()->user()->id,
    //                 'no_surat' => $this->no_surat,
    //                 'tgl_pakai' => $this->tgl_pakai,
    //                 'file' => $file_name,
    //                 'stts' => 'proses'
    //             ]);
    //         }
    //         $this->reset(['no_surat', 'tgl_pakai', 'file']);
    //         $this->emit('refreshPaklaring');
    //         $this->alert('success', 'Paklaring berhasil diupload');
    //     } catch (\Throwable $th) {
    //         $this->alert('error', 'Paklaring gagal diupload');
    //     }
    // }
}
