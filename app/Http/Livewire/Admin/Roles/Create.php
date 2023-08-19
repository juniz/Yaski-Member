<?php

namespace App\Http\Livewire\Admin\Roles;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;
    protected $listeners = ['tambah'];
    public $name;

    public function render()
    {
        return view('livewire.admin.roles.create');
    }

    public function tambah()
    {
        $this->dispatchBrowserEvent('openModalRole');
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
            \Spatie\Permission\Models\Role::create([
                'name' => $this->name
            ]);
            $this->reset(['name']);
            $this->emit('refreshRole');
            $this->dispatchBrowserEvent('closeModalRole');
            $this->alert('success', 'Berhasil menyimpan data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('closeModalRole');
            $this->alert('error', 'Gagal menyimpan data', [
                'position' =>  'center',
                'toast' =>  false
            ]);
        }
    }
}
