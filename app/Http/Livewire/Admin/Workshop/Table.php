<?php

namespace App\Http\Livewire\Admin\Workshop;

use Livewire\Component;
use App\Models\Workshop;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Table extends Component
{
    use LivewireAlert;
    public $idWorkshop;
    protected $listeners = ['refreshWorkshop' => '$refresh', 'hapusWorkshop' => 'hapus', 'confirmHapusWorkshop' => 'confirmHapus'];

    public function render()
    {
        return view('livewire.admin.workshop.table', [
            'workshops' => Workshop::all()
        ]);
    }

    public function confirmHapus($id)
    {
        $this->idWorkshop = $id;
        $this->confirm('Apakah anda yakin ingin menghapus data ini?', [
            'onConfirmed' => 'hapusWorkshop',
        ]);
    }

    public function hapus()
    {
        try {
            Workshop::find($this->idWorkshop)->delete();
            $this->alert('success', 'Berhasil Menghapus Data');
            $this->emit('refreshWorkshop');
        } catch (\Exception) {
            $this->alert('error', 'Gagal Menghapus Data');
        }
    }

    public function setStatus($id)
    {
        $workshop = Workshop::find($id);
        $workshop->stts = $workshop->stts == 1 ? '0' : '1';
        $workshop->save();
        $this->alert('success', 'Berhasil Mengubah Status');
        $this->emit('refreshWorkshop');
    }
}
