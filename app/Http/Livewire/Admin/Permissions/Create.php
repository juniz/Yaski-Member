<?php

namespace App\Http\Livewire\Admin\Permissions;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;
    protected $listeners = ['tambah', 'refreshData'];
    public $name;
    public function render()
    {
        return view('livewire.admin.permissions.create');
    }

    public function refreshData()
    {
        $this->emit('testData');
    }

    public function tambah()
    {
        $this->dispatchBrowserEvent('openModalPermission');
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
            \Spatie\Permission\Models\Permission::create([
                'name' => $this->name
            ]);
            $this->reset(['name']);
            $this->emit('refreshPermissions');
            $this->dispatchBrowserEvent('closeModalPermission');
            $this->alert('success', 'Berhasil menyimpan data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('closeModalPermission');
            $this->alert('error', 'Gagal menyimpan data', [
                'position' =>  'center',
                'toast' =>  false
            ]);
        }
    }
}
