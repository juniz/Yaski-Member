<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\Paklaring;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UploadPaklaring extends Component
{
    use WithFileUploads, LivewireAlert;
    public $no_surat, $tgl_pakai, $file, $paklaring;
    // protected $listeners = ['refreshPaklaring' => '$refresh'];

    public function mount()
    {
        $this->paklaring = Paklaring::where('user_id', auth()->user()->id)->first();
        $this->no_surat = $this->paklaring->no_surat ?? '';
        $this->tgl_pakai = $this->paklaring->tgl_pakai ?? '';
    }

    public function render()
    {
        return view('livewire.component.upload-paklaring');
    }

    public function simpan()
    {
        $this->validate([
            'no_surat' => 'required',
            'tgl_pakai' => 'required',
            'file' => 'required|file|mimes:pdf|max:1024'
        ], [
            'no_surat.required' => 'Nomor surat tidak boleh kosong',
            'tgl_pakai.required' => 'Tanggal pakai tidak boleh kosong',
            'file.required' => 'File paklaring tidak boleh kosong',
            'file.file' => 'File paklaring harus berupa file',
            'file.mimes' => 'File paklaring harus berupa pdf',
            'file.max' => 'Ukuran file paklaring maksimal 1MB'
        ]);

        try {
            $file_name = 'PF-' . time() . '.' . $this->file->extension();
            $this->file->storeAs('public/pakelaring', $file_name);
            if (file_exists(storage_path('app/public/pakelaring/' . $this->paklaring->file))) {
                unlink(storage_path('app/public/pakelaring/' . $this->paklaring->file));
            }
            if (!empty($this->paklaring)) {
                if ($this->paklaring->stts != 'disetujui') {
                    $this->paklaring->update([
                        'no_surat' => $this->no_surat,
                        'tgl_pakai' => $this->tgl_pakai,
                        'file' => $file_name,
                        'stts' => 'proses'
                    ]);
                    $this->emit('refreshPaklaring');
                    $this->dispatchBrowserEvent('simpanPaklaring');
                    $this->alert('success', 'Paklaring berhasil diubah');
                } else {
                    $this->alert('info', 'Paklaring sudah disetujui, tidak bisa diubah', [
                        'position' =>  'center',
                        'toast' =>  false,
                    ]);
                }
            } else {
                Paklaring::create([
                    'user_id' => auth()->user()->id,
                    'no_surat' => $this->no_surat,
                    'tgl_pakai' => $this->tgl_pakai,
                    'file' => $file_name,
                    'stts' => 'proses'
                ]);
                $this->emit('refreshPaklaring');
                $this->dispatchBrowserEvent('simpanPaklaring');
                $this->alert('success', 'Paklaring berhasil diupload');
            }
            // $this->reset(['no_surat', 'tgl_pakai', 'file']);
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            $this->alert('error', $th->getMessage(), [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        }
    }
}
