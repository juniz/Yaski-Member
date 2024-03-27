<?php

namespace App\Http\Livewire\Mou;

use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Mou;

class Persetujuan extends Component
{
    use WithFileUploads, LivewireAlert;
    public Mou $mou;
    public $file_kedua;
    public $alasan;
    protected $listeners = ['modalPersetujuan', 'docPersetujuan'];

    public function render()
    {
        return view('livewire.mou.persetujuan');
    }

    public function modalPersetujuan(Mou $mou)
    {
        $this->mou = $mou;
        $this->dispatchBrowserEvent('modalPersetujuan');
    }

    public function docPersetujuan(Mou $mou)
    {
        $this->mou = $mou;
        $this->dispatchBrowserEvent('docPersetujuan');
    }

    public function simpanSetuju()
    {
        $this->validate([
            'file_kedua' => 'required|file|mimes:pdf|max:2048'
        ], [
            'file_kedua.required' => 'File MOU tidak boleh kosong',
            'file_kedua.file' => 'File MOU harus berupa file',
            'file_kedua.mimes' => 'File MOU harus berupa pdf',
            'file_kedua.max' => 'Ukuran file MOU maksimal 2MB'
        ]);

        try {
            $file_name = 'MOU-' . time() . '.' . $this->file_kedua->extension();
            $this->file_kedua->storeAs('public/persetujuan', $file_name);
            if (file_exists(storage_path('app/public/persetujuan/' . $this->mou->file_kedua))) {
                @unlink(storage_path('app/public/persetujuan/' . $this->mou->file_kedua));
            }
            $this->mou->update([
                'file_kedua' => $file_name,
                'stts' => 'disetujui'
            ]);
            $this->emit('refreshMou');
            $this->reset('file_kedua');
            $this->dispatchBrowserEvent('simpanPersetujuan');
            $this->alert('success', 'MOU berhasil disetujui');
        } catch (\Throwable $th) {
            $this->alert('error', 'MOU gagal disetujui\n' . $th->getMessage());
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
            $this->mou->update([
                'alasan' => $this->alasan,
                'stts' => 'ditolak'
            ]);
            $this->emit('refreshMou');
            $this->reset('alasan');
            $this->dispatchBrowserEvent('simpanPersetujuan');
            $this->alert('success', 'MOU berhasil ditolak');
        } catch (\Throwable $th) {
            $this->alert('error', 'MOU gagal ditolak\n' . $th->getMessage());
        }
    }
}
