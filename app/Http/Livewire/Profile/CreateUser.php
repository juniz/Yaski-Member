<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CreateUser extends Component
{
    use LivewireAlert, WithFileUploads;
    public $name, $email, $password, $password_confirmation, $role, $avatar;
    protected $listeners = ['tambah-user' => 'tambah'];
    public function render()
    {
        return view('livewire.profile.create-user', [
            'roles' => \Spatie\Permission\Models\Role::all()
        ]);
    }

    public function tambah()
    {
        $this->dispatchBrowserEvent('openModalUser');
    }

    public function simpan()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'role' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'avatar' => 'required|image|max:1024'
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah ada',
            'role.required' => 'Role tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong',
            'password_confirmation.same' => 'Konfirmasi password tidak sama dengan password',
            'avatar.required' => 'Avatar tidak boleh kosong',
            'avatar.image' => 'Avatar harus berupa gambar',
            'avatar.max' => 'Ukuran avatar maksimal 1MB'
        ]);

        try {
            $avatar = $this->name . '-' . time() . '.' . $this->avatar->extension();
            $this->avatar->storeAs('public/avatar', $avatar);
            \App\Models\User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => \Hash::make($this->password),
                'avatar' => $avatar
            ])->assignRole($this->role);
            $this->reset(['name', 'email', 'password', 'password_confirmation', 'avatar']);
            $this->emit('refreshMembers');
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
