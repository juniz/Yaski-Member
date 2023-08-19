<?php

namespace App\Http\Livewire\Admin\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Table extends Component
{
    use WithPagination, LivewireAlert;
    public $search;
    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshPermissions' => '$refresh', 'testData', 'deletePermission'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.permissions.table', [
            'permissions' => Permission::where('name', 'like', '%' . $this->search . '%')->paginate(5)
        ]);
    }

    public function openDialog($id)
    {
        $this->confirm('Apakah anda yakin ingin menghapus data ini?', [
            'onConfirmed' => 'deletePermission',
            'inputAttributes' => ['id' => $id],
        ]);
    }

    public function deletePermission($data)
    {
        $id = $data['data']['inputAttributes']['id'];
        try {
            $permission = Permission::find($id);
            $permission->delete();
            $this->emit('refreshPermissions');
            $this->alert('success', 'Berhasil menghapus data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        } catch (\Exception $e) {
            $this->alert('error', 'Gagal menghapus data', [
                'position' =>  'center',
                'toast' =>  false,
                'onConfirmed' => 'getTeam'
            ]);
        }
    }
}
