<?php

namespace App\Http\Livewire\Profile;

use Livewire\WithFileUploads;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Member extends Component
{
    use WithFileUploads, LivewireAlert;
    public $members, $idMember, $user, $name, $email, $avatar, $telegram, $telp, $modeEdit = false;
    protected $listeners = ['getTeam', 'deleteTeam', 'refreshMembers' => '$refresh'];
    public function mount($user)
    {
        $this->user = $user;
        $this->getTeam();
    }

    public function render()
    {
        return view('livewire.profile.member', [
            'members' => $this->user->hasTeams
        ]);
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
        $this->idMember = $id;
        $user = $this->user->hasTeams()->find($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->telegram = $user->telegram;
        $this->telp = $user->telp;
        $this->dispatchBrowserEvent('openModalTeam');
    }

    public function simpanMember()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'avatar' => 'image|max:1024|nullable',
            'telegram' => 'required',
            'telp' => 'required|numeric|digits_between:10,13',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'avatar.image' => 'Avatar harus berupa gambar',
            'avatar.max' => 'Ukuran avatar maksimal 1MB',
            'telegram.required' => 'Username telegram tidak boleh kosong',
            'telp.required' => 'Nomor telepon tidak boleh kosong',
            'telp.numeric' => 'Nomor telepon harus berupa angka',
            'telp.digits_between' => 'Nomor telepon minimal 10 dan maksimal 13 angka',
        ]);

        $avatarName = '';
        try {
            if ($this->modeEdit) {
                $user = $this->user->hasTeams()->find($this->idMember);
                if($this->avatar){
                    @Storage::delete('public/' . $user->avatar);
                    $avatarName = $this->name . '-' . time() . '.' . $this->avatar->extension();
                    $this->avatar->storeAs('public/teams', $avatarName);
                }else{
                    $avatarName = $user->avatar;
                }
                $user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'telegram' => $this->telegram,
                    'telp' => $this->telp,
                    'avatar' => $avatarName
                ]);
                $this->modeEdit = false;
            } else {
                $avatarName = $this->name . '-' . time() . '.' . $this->avatar->extension();
                $this->avatar->storeAs('public/teams', $avatarName);
                $this->user->hasTeams()->create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'avatar' => $avatarName ?? null,
                    'telegram' => $this->telegram,
                    'telp' => $this->telp,
                ]);
            }
            $this->reset(['name', 'email', 'avatar', 'telegram', 'telp']);
            $this->dispatchBrowserEvent('closeModalTeam');
            $this->alert('success', 'Berhasil menyimpan data', [
                'position' =>  'center',
                'toast' =>  false,
                'onConfirmed' => 'getTeam'
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('closeModalTeam');
            $this->alert('error', 'Data gagal dihapus', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        }
    }

    public function confirmDelete($id)
    {
        $this->confirm('Apakah anda yakin ingin menghapus data ini?', [
            'onConfirmed' => 'deleteTeam',
            'inputAttributes' => ['id' => $id],
        ]);
    }

    public function deleteTeam($data)
    {
        $id = $data['data']['inputAttributes']['id'];
        try {
            $user = $this->user->hasTeams()->find($id);
            Storage::delete('public/' . $user->avatar);
            $user->delete();
            $this->reset(['name', 'email', 'avatar']);
            $this->emit('refreshMembers');
            $this->alert('success', 'Berhasil menghapus data', [
                'position' =>  'center',
                'toast' =>  false,
                'onConfirmed' => 'getTeam'
            ]);
        } catch (\Exception $e) {
            $this->alert('error', 'Gagal menghapus data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        }
    }
}
