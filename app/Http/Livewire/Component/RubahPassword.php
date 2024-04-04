<?php

namespace App\Http\Livewire\Component;

use App\Models\User;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RubahPassword extends Component
{
    use LivewireAlert;
    public $password;
    public $idUser;
    public User $user;

    protected $listeners = ['changeIdUser'];

    public function render()
    {
        return view('livewire.component.rubah-password');
    }

    public function changeIdUser($idUser)
    {
        $this->idUser = $idUser;
        $this->user = User::find($this->idUser);
    }

    public function changePassword()
    {
        $this->validate([
            'password' => 'required|min:8',
        ], [
            'password.required' => 'Password baru tidak boleh kosong',
            'password.min' => 'Password baru minimal 8 karakter',
        ]);

        try {
            $user = User::find($this->idUser);
            $user->password = bcrypt($this->password);
            $user->save();

            $this->alert('success', 'Password berhasil diubah');
        } catch (\Exception $e) {
            $this->alert('error', 'Gagal merubah password');
        }
    }
}
