<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Support\Facades\App;
use Livewire\WithFileUploads;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Str;

class Member extends Component
{
    use WithFileUploads, LivewireAlert;
    public $members, $idMember, $user, $name, $email, $avatar, $telegram, $telp, $sk_pic, $modeEdit = false;
    public $tempAvatar, $tempSkPic;
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
        $this->tempAvatar = $user->avatar;
        $this->tempSkPic = $user->sk_pic;
        $this->dispatchBrowserEvent('openModalTeam');
    }

    public function simpanMember()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'avatar' => 'required|image|max:1024',
            'telegram' => 'required|regex:/^@?(\w){1,15}$/',
            'telp' => 'required|numeric|digits_between:10,13',
            'sk_pic' => 'required|max:2048|mimes:pdf',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'avatar.image' => 'Foto PIC harus berupa gambar',
            'avatar.max' => 'Ukuran Foto maksimal 1MB',
            'avatar.required' => 'Foto PIC tidak boleh kosong',
            'telegram.required' => 'Username telegram tidak boleh kosong',
            'telegram.regex' => 'Username telegram tidak valid',
            'telp.required' => 'Nomor telepon tidak boleh kosong',
            'telp.numeric' => 'Nomor telepon harus berupa angka',
            'telp.digits_between' => 'Nomor telepon minimal 10 dan maksimal 13 angka',
            'sk_pic.required' => 'SK PIC tidak boleh kosong',
            'sk_pic.max' => 'Ukuran SK PIC maksimal 2MB',
            'sk_pic.mimes' => 'File SK PIC harus berupa PDF',
        ]);

        $avatarName = '';
        $skPicName = '';
        try {
            if ($this->modeEdit) {
                $user = $this->user->hasTeams()->find($this->idMember);
                if ($this->avatar) {
                    @Storage::delete('public/' . $user->avatar);
                    $avatarName = $this->name . '-' . time() . '.' . $this->avatar->extension();
                    $this->avatar->storeAs('public/teams', $avatarName);
                } else {
                    $avatarName = $user->avatar;
                }
                $user->update([
                    'name' => Str::upper($this->name),
                    'email' => Str::lower($this->email),
                    'telegram' => $this->telegram,
                    'telp' => $this->telp,
                    'avatar' => $avatarName
                ]);
                $this->modeEdit = false;
            } else {
                $avatarName = $this->name . '-' . time() . '.' . $this->avatar->extension();
                $skPicName = 'SK-' . $this->name . '-' . time() . '.' . $this->sk_pic->extension();
                $this->avatar->storeAs('public/teams', $avatarName);
                $this->sk_pic->storeAs('public/sk_pic', $skPicName);
                $this->user->hasTeams()->create([
                    'name' => Str::upper($this->name),
                    'email' => Str::lower($this->email),
                    'avatar' => $avatarName,
                    'telegram' => $this->telegram,
                    'telp' => $this->telp,
                    'sk_pic' => $skPicName
                ]);
            }
            $this->reset(['name', 'email', 'avatar', 'telegram', 'telp']);
            $this->dispatchBrowserEvent('closeModalTeam');
            $this->emit('load-alert');
            $this->emit('cekPaklaring');
            $this->alert('success', 'Berhasil menyimpan data', [
                'position' =>  'center',
                'toast' =>  false,
                'onConfirmed' => 'getTeam'
            ]);
        } catch (\Exception $e) {
            // $this->dispatchBrowserEvent('closeModalTeam');
            $this->alert('error', App::environment('local') ? $e->getMessage() : 'Terjadi Kesalahan', [
                'position' =>  'center',
                'timeout' =>  '',
                'toast' =>  false,
                'confirmButtonText' => 'Tutup'
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
            @Storage::delete('public/teams/' . $user->avatar);
            @Storage::delete('public/sk_pic/' . $user->sk_pic);
            $user->delete();
            $this->reset(['name', 'email', 'avatar']);
            $this->emit('refreshMembers');
            $this->emit('cekPaklaring');
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
