<?php

namespace App\Http\Livewire\Profile;

use Livewire\WithFileUploads;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Member extends Component
{
    use WithFileUploads;
    public $members, $user, $name, $email, $avatar, $modeEdit = false;
    protected $listeners = ['getTeam'];
    public function mount($user)
    {
        $this->user = $user;
        $this->getTeam();
    }

    public function render()
    {
        return view('livewire.profile.member');
    }

    public function openModal()
    {
        $this->dispatchBrowserEvent('openModalTeam');
    }

    public function getTeam()
    {
        $this->members = $this->user->hasTeams;
    }

    public function editTeam($id)
    {
        $this->modeEdit = true;
        $user = $this->user->hasTeams()->find($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->dispatchBrowserEvent('openModalTeam');
    }

    public function simpanMember()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'avatar' => 'image|max:1024',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'avatar.image' => 'Avatar harus berupa gambar',
            'avatar.max' => 'Ukuran avatar maksimal 1MB',
        ]);

        try {
            if ($this->modeEdit) {
                $user = $this->user->hasTeams()->find($this->user->id);
                $user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'avatar' => $this->avatar->storeAs('avatar', $this->name . '-' . time() . '.' . $this->avatar->extension(), 'public')
                ]);
                $this->modeEdit = false;
            } else {
                $this->user->hasTeams()->create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'avatar' => $this->avatar->storeAs('avatar', $this->name . '-' . time() . '.' . $this->avatar->extension(), 'public')
                ]);
            }
            $this->reset(['name', 'email', 'avatar']);
            $this->dispatchBrowserEvent('closeModalTeam');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function deleteTeam($id)
    {
        $user = $this->user->hasTeams()->find($id);
        Storage::delete('public/' . $user->avatar);
        $user->delete();
        $this->getTeam();
    }
}
