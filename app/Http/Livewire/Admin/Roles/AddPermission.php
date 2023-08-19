<?php

namespace App\Http\Livewire\Admin\Roles;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class AddPermission extends Component
{
    use LivewireAlert, WithPagination;
    public $search, $selectedPermission = [], $idRole, $roleUser;
    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshPermission' => '$refresh', 'openModalPermission'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.roles.add-permission', [
            'permissions' => \Spatie\Permission\Models\Permission::where('name', 'like', '%' . $this->search . '%')->paginate(5)
        ]);
    }

    public function openModalPermission($id)
    {
        $this->idRole = $id;
        $this->dispatchBrowserEvent('openModalPermission');
    }

    public function simpan()
    {
        $this->validate([
            'selectedPermission' => 'required'
        ], [
            'selectedPermission.required' => 'Permission tidak boleh kosong'
        ]);

        try {

            $role = \Spatie\Permission\Models\Role::find($this->idRole);
            foreach ($this->selectedPermission as $key => $value) {
                $permission = \Spatie\Permission\Models\Permission::find($value);
                $role->givePermissionTo($permission->name);
            }
            $this->reset(['selectedPermission', 'idRole']);
            $this->emit('refreshRole');
            $this->dispatchBrowserEvent('closeModalPermission');
            $this->alert('success', 'Berhasil menyimpan data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('closeModalPermission');
            $this->alert('error', $e->getMessage(), [
                'position' =>  'center',
                'toast' =>  false
            ]);
        }
    }
}
