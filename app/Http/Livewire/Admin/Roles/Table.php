<?php

namespace App\Http\Livewire\Admin\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Spatie\Permission\Models\Role;

class Table extends Component
{
    use WithPagination, LivewireAlert;
    public $search;
    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshRole' => '$refresh', 'deleteRole', 'hapusUserRole', 'hapusPermissionRole'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.roles.table', [
            'roles' => Role::where('name', 'like', '%' . $this->search . '%')->paginate(5)
        ]);
    }

    public function confirmHapusUserRole($id, $role)
    {
        $this->confirm('Apakah anda yakin ingin menghapus data ini?', [
            'onConfirmed' => 'hapusUserRole',
            'inputAttributes' => ['id' => $id, 'role' => $role],
        ]);
    }

    public function hapusUserRole($data)
    {
        $id = $data['data']['inputAttributes']['id'];
        $role = $data['data']['inputAttributes']['role'];
        try {
            $user = \App\Models\User::find($id);
            $user->removeRole($role);
            $this->emit('refreshUser');
            $this->alert('success', 'Berhasil menghapus data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        } catch (\Exception $e) {
            $this->alert('error', 'Gagal menghapus data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        }
    }

    public function confirmHapusPermission($id, $role)
    {
        $this->confirm('Apakah anda yakin ingin menghapus data ini?', [
            'onConfirmed' => 'hapusPermissionRole',
            'inputAttributes' => ['id' => $id, 'role' => $role],
        ]);
    }

    public function hapusPermissionRole($data)
    {
        $id = $data['data']['inputAttributes']['id'];
        $role = $data['data']['inputAttributes']['role'];
        try {
            $role = \Spatie\Permission\Models\Role::findByName($role);
            $permission = \Spatie\Permission\Models\Permission::find($id);
            $role->revokePermissionTo($permission->name);
            $this->emit('refreshPermission');
            $this->alert('success', 'Berhasil menghapus data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        } catch (\Exception $e) {
            $this->alert('error', 'Gagal menghapus data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        }
    }

    public function openDialog($id)
    {
        $this->confirm('Apakah anda yakin ingin menghapus data ini?', [
            'onConfirmed' => 'deleteRole',
            'inputAttributes' => ['id' => $id],
        ]);
    }

    public function deleteRole($data)
    {
        $id = $data['data']['inputAttributes']['id'];
        try {
            $permission = Role::find($id);
            $permission->delete();
            $this->emit('refreshRole');
            $this->alert('success', 'Berhasil menghapus data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        } catch (\Exception $e) {
            $this->alert('error', 'Gagal menghapus data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        }
    }
}
