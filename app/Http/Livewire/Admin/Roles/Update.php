<?php

namespace App\Http\Livewire\Admin\Roles;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Update extends Component
{
    use LivewireAlert;
    public $name, $idRole;
    protected $listeners = ['openUpdateModal'];

    public function render()
    {
        return view('livewire.admin.roles.update');
    }

    public function openUpdateModal($id)
    {
        $role = \Spatie\Permission\Models\Role::find($id);
        $this->idRole = $role->id;
        $this->name = $role->name;
        $this->dispatchBrowserEvent('openModalUpdateRole');
    }

    public function simpan()
    {
        $this->validate([
            'name' => 'required|unique:roles,name'
        ], [
            'name.required' => 'Nama role tidak boleh kosong',
            'name.unique' => 'Nama role sudah ada'
        ]);

        try {
            $role = \Spatie\Permission\Models\Role::find($this->idRole);
            $role->update([
                'name' => $this->name
            ]);
            $this->reset(['name', 'idRole']);
            $this->emit('refreshRole');
            $this->dispatchBrowserEvent('closeModalUpdateRole');
            $this->alert('success', 'Berhasil merubah data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('closeModalUpdateRole');
            $this->alert('error', 'Gagal merubah data', [
                'position' =>  'center',
                'toast' =>  false
            ]);
        }
    }
}
