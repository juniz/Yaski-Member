<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditUser extends Component
{
    use LivewireAlert, WithFileUploads;
    public $idUser, $name, $email, $password, $password_confirmation, $role, $roleUser, $avatar;
    protected $listeners = ['edit-user' => 'ubah'];

    public function render()
    {
        return view('livewire.profile.edit-user', [
            'roles' => \Spatie\Permission\Models\Role::all()
        ]);
    }

    public function ubah($id)
    {
        $user = \App\Models\User::find($id);
        $this->idUser = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->pluck('name')->first();
        $this->dispatchBrowserEvent('openModalEditUser');
    }

    public function simpan()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'avatar' => 'image|max:1024|nullable',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'role.required' => 'Role tidak boleh kosong',
            'avatar.image' => 'Avatar harus berupa gambar',
            'avatar.max' => 'Ukuran avatar maksimal 1MB',
        ]);

        try {
            $user = \App\Models\User::find($this->idUser);
            if ($this->avatar) {
                Storage::disk('public')->delete($user->avatar);
                $avatar = $this->avatar->storeAs('avatar', $this->name . '-' . time() . '.' . $this->avatar->extension(), 'public');
            } else {
                $avatar = $user->avatar;
            }
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'avatar' => $avatar
            ]);
            $user->syncRoles($this->role);
            $this->reset(['name', 'email', 'password', 'password_confirmation', 'avatar']);
            $this->emit('refreshMembers');
            $this->dispatchBrowserEvent('closeModalEditUser');
            $this->alert('success', 'Berhasil mengubah data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('closeModalEditUser');
            $this->alert('error', 'Gagal mengubah data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        }
    }
}
