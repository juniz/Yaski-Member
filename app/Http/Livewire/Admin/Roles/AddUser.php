<?php

namespace App\Http\Livewire\Admin\Roles;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class AddUser extends Component
{
    use LivewireAlert, WithPagination;
    public $search, $selectedUser = [], $idRole, $roleUser;
    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshUser' => '$refresh', 'openModalUser'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.roles.add-user', [
            'users' => \App\Models\User::where('name', 'like', '%' . $this->search . '%')->paginate(5)
        ]);
    }

    public function openModalUser($id)
    {
        $this->idRole = $id;
        $this->dispatchBrowserEvent('openModalUser');
    }

    public function simpan()
    {
        $this->validate([
            'selectedUser' => 'required'
        ], [
            'selectedUser.required' => 'User tidak boleh kosong'
        ]);
        try {
            $role = \Spatie\Permission\Models\Role::find($this->idRole);
            foreach ($this->selectedUser as $key => $value) {
                $user = \App\Models\User::find($value);
                $user->assignRole($role->name);
            }
            $this->reset(['selectedUser', 'idRole']);
            $this->emit('refreshRole');
            $this->dispatchBrowserEvent('closeModalUser');
            $this->alert('success', 'Berhasil menyimpan data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('closeModalUser');
            $this->alert('error', 'Gagal menyimpan data', [
                'position' =>  'center',
                'toast' =>  false
            ]);
        }
    }
}
