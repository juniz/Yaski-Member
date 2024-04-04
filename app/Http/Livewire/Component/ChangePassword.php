<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ChangePassword extends Component
{
    use LivewireAlert;
    public $newPassword;
    public $currentPassword;
    public $confirmPassword;
    public function render()
    {
        return view('livewire.component.change-password');
    }

    public function changePassword()
    {
        $this->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|same:newPassword',
        ], [
            'currentPassword.required' => 'Password lama tidak boleh kosong',
            'newPassword.required' => 'Password baru tidak boleh kosong',
            'newPassword.min' => 'Password baru minimal 8 karakter',
            'confirmPassword.required' => 'Konfirmasi password tidak boleh kosong',
            'confirmPassword.same' => 'Konfirmasi password tidak sama dengan password baru',
        ]);

        $user = Auth::user();

        if (Hash::check($this->currentPassword, $user->password)) {
            $user->password = Hash::make($this->newPassword);
            $user->save();

            Session::flush();
            Auth::logout();

            return redirect()->route('root');
        } else {
            $this->alert('error', 'Password lama salah');
        }
    }
}
