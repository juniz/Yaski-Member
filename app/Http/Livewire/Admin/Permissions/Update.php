<?php

namespace App\Http\Livewire\Admin\Permissions;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Update extends Component
{
    use LivewireAlert;
    public $name, $idPermission;
    protected $listeners = ['openUpdateModal'];
    public function render()
    {
        return view('livewire.admin.permissions.update');
    }

    public function openUpdateModal($id)
    {
        $permission = \Spatie\Permission\Models\Permission::find($id);
        $this->idPermission = $permission->id;
        $this->name = $permission->name;
        $this->dispatchBrowserEvent('openModalUpdatePermission');
    }

    public function simpan()
    {
        $this->validate([
            'name' => 'required|unique:permissions,name'
        ], [
            'name.required' => 'Nama permission tidak boleh kosong',
            'name.unique' => 'Nama permission sudah ada'
        ]);

        try {
            $permission = \Spatie\Permission\Models\Permission::find($this->idPermission);
            $permission->update([
                'name' => $this->name
            ]);
            $this->reset(['name', 'idPermission']);
            $this->emit('refreshPermissions');
            $this->dispatchBrowserEvent('closeModalUpdatePermission');
            $this->alert('success', 'Berhasil merubah data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('closeModalUpdatePermission');
            $this->alert('error', 'Gagal merubah data', [
                'position' =>  'center',
                'toast' =>  false
            ]);
        }
    }
}
