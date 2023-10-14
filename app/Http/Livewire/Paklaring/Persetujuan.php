<?php

namespace App\Http\Livewire\Paklaring;

use App\Models\Paklaring;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Persetujuan extends Component
{
    use WithFileUploads, LivewireAlert;
    public Paklaring $paklaring;
    public $file, $alasan;
    protected $listeners = ['modalPersetujuan', 'docPersetujuan'];

    public function render()
    {
        return view('livewire.paklaring.persetujuan');
    }

    public function modalPersetujuan(Paklaring $paklaring)
    {
        $this->paklaring = $paklaring;
        $this->dispatchBrowserEvent('modalPersetujuan');
    }

    public function docPersetujuan(Paklaring $paklaring)
    {
        $this->paklaring = $paklaring;
        $this->dispatchBrowserEvent('docPersetujuan');
    }

    public function simpanSetuju()
    {
        $this->validate([
            'file' => 'required|file|mimes:pdf|max:1024'
        ], [
            'file.required' => 'File paklaring tidak boleh kosong',
            'file.file' => 'File paklaring harus berupa file',
            'file.mimes' => 'File paklaring harus berupa pdf',
            'file.max' => 'Ukuran file paklaring maksimal 1MB'
        ]);

        try {
            $file_name = 'PF-' . time() . '.' . $this->file->extension();
            $this->file->storeAs('public/persetujuan', $file_name);
            if (file_exists(storage_path('app/public/persetujuan/' . $this->paklaring->file_verif))) {
                @unlink(storage_path('app/public/persetujuan/' . $this->paklaring->file_verif));
            }
            $this->paklaring->update([
                'file_verif' => $file_name,
                'stts' => 'disetujui'
            ]);
            $this->emit('refreshPaklaring');
            $this->reset('file');
            $this->dispatchBrowserEvent('simpanPersetujuan');
            $this->alert('success', 'Paklaring berhasil disetujui');
        } catch (\Throwable $th) {
            $this->alert('error', 'Paklaring gagal disetujui\n' . $th->getMessage());
        }
    }

    public function simpanTolak()
    {
        $this->validate([
            'alasan' => 'required'
        ], [
            'alasan.required' => 'Alasan tidak boleh kosong'
        ]);

        try {
            $this->paklaring->update([
                'alasan' => $this->alasan,
                'stts' => 'ditolak'
            ]);
            $this->emit('refreshPaklaring');
            $this->reset('alasan');
            $this->dispatchBrowserEvent('tolakPersetujuan');
            $this->alert('success', 'Paklaring berhasil ditolak');
        } catch (\Throwable $th) {
            $this->alert('error', 'Paklaring gagal ditolak\n' . $th->getMessage());
        }
    }
}
