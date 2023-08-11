<?php

namespace App\Http\Livewire\Profile;

use App\Models\Paklaring;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class GrideMembers extends Component
{
    use WithFileUploads;
    public $members, $pakelaring, $file, $idUser;
    public function render()
    {
        return view('livewire.profile.gride-members');
    }

    public function mount()
    {
        $this->getMembers();
    }

    public function modalPakelaring($id)
    {
        $this->idUser = $id;
        $this->getPakelaring($id);
        $this->dispatchBrowserEvent('modalPakelaring');
    }

    public function getPakelaring($id)
    {
        $this->pakelaring = Paklaring::where('user_id', $id)->first();
    }

    public function getMembers()
    {
        $this->members = User::all();
    }

    public function simpan()
    {
        $this->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ], [
            'file.required' => 'File tidak boleh kosong',
            'file.mimes' => 'File harus berupa pdf',
            'file.max' => 'File maksimal 2MB',
        ]);

        try {
            Storage::delete('public/pakelaring/' . $this->pakelaring->file);
            $fileName = 'PF-' . time() . '.' . $this->file->extension();
            $this->file->storeAs('public/pakelaring', $fileName);
            $this->pakelaring->update([
                'file' => $fileName,
                'stts' => '1'
            ]);
            $this->getPakelaring($this->idUser);
            $this->dispatchBrowserEvent('swal', ['title' => 'Berhasil', 'type' => 'success', 'text' => 'Pakelaring berhasil diupload']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal', ['title' => 'Gagal', 'type' => 'error', 'text' => 'Pakelaring gagal diupload']);
        }
    }
}
