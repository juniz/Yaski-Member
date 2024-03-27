<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\App;
use Livewire\WithFileUploads;
use App\Models\Team;

class EditMember extends Component
{
    use WithFileUploads, LivewireAlert;
    public $idMember, $user, $name, $email, $avatar, $telegram, $telp, $sk_pic;
    protected $listeners = ['editMember' => 'dataEdit'];
    public function render()
    {
        return view('livewire.profile.edit-member');
    }

    public function dataEdit($id)
    {
        $this->idMember = $id;
        $data = Team::find($id);
        $this->name = $data->name;
        $this->email = $data->email;
        $this->telegram = $data->telegram;
        $this->telp = $data->telp;
        // $this->sk_pic = $data->sk_pic;
        // $this->avatar = $data->avatar;
        $this->emit('openModalEditTeam');
    }

    // public function updateAvatar()
    // {
    //     $this->validate([
    //         'avatar' => 'image|max:1024'
    //     ], [
    //         'avatar.image' => 'Avatar harus berupa gambar',
    //         'avatar.max' => 'Ukuran avatar maksimal 1MB'
    //     ]);
    //     $fileName = $this->name . '-' . time() . '.' . $this->avatar->extension();
    //     $this->avatar->storeAs('public/teams', $fileName);
    //     try {
    //         $team = Team::find($this->idMember);
    //         $team->avatar = $fileName;
    //         $team->save();
    //         $this->emit('getTeam');
    //         $this->alert('success', 'Foto berhasil diubah');
    //     } catch (\Exception $e) {
    //         $this->alert('error', App::environment('local') ? $e->getMessage() : 'Terjadi Kesalahan', [
    //             'position' =>  'center',
    //             'timeout' =>  '',
    //             'toast' =>  false,
    //             'confirmButtonText' => 'Tutup'
    //         ]);
    //     }
    // }

    // public function updatedSkPic()
    // {
    //     $this->validate([
    //         'sk_pic' => 'max:2048|mimes:pdf'
    //     ], [
    //         'sk_pic.image' => 'SK PIC harus berupa pdf',
    //         'sk_pic.max' => 'Ukuran SK PIC maksimal 2MB'
    //     ]);
    //     $fileName = 'SK-' . $this->name . '-' . time() . '.' . $this->sk_pic->extension();
    //     $this->sk_pic->storeAs('public/sk_pic', $fileName);
    //     try {
    //         $team = Team::find($this->idMember);
    //         $team->sk_pic = $fileName;
    //         $team->save();
    //         $this->emit('getTeam');
    //         $this->alert('success', 'SK PIC berhasil diubah');
    //     } catch (\Exception $e) {
    //         $this->alert('error', App::environment('local') ? $e->getMessage() : 'Terjadi Kesalahan', [
    //             'position' =>  'center',
    //             'timeout' =>  '',
    //             'toast' =>  false,
    //             'confirmButtonText' => 'Tutup'
    //         ]);
    //     }
    // }

    public function edit()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'telegram' => 'required|regex:/^@?(\w){1,15}$/',
            'telp' => 'required|numeric'
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'telegram.required' => 'Telegram tidak boleh kosong',
            'telegram.regex' => 'Telegram tidak valid',
            'telp.required' => 'Telp tidak boleh kosong',
            'telp.numeric' => 'Telp harus berupa angka'
        ]);

        $fileAvatar = null;
        $fileSkPic = null;
        try {
            if (isset($this->avatar)) {
                $this->validate([
                    'avatar' => 'image|max:1024'
                ], [
                    'avatar.image' => 'Foto harus berupa gambar',
                    'avatar.max' => 'Ukuran Foto maksimal 1MB'
                ]);
                @Storage::delete('public/teams/' . $this->avatar);
                $fileName = $this->name . '-' . time() . '.' . $this->avatar->extension();
                $this->avatar->storeAs('public/teams', $fileName);
                $fileAvatar = $fileName;
            }
            if (isset($this->sk_pic)) {
                $this->validate([
                    'sk_pic' => 'max:2048|mimes:pdf'
                ], [
                    'sk_pic.image' => 'SK PIC harus berupa pdf',
                    'sk_pic.max' => 'Ukuran SK PIC maksimal 2MB'
                ]);
                @Storage::delete('public/sk_pic/' . $this->sk_pic);
                $fileName = 'SK-' . $this->name . '-' . time() . '.' . $this->sk_pic->extension();
                $this->sk_pic->storeAs('public/sk_pic', $fileName);
                $fileSkPic = $fileName;
            }
            $team = Team::find($this->idMember);
            $team->name = $this->name;
            $team->email = $this->email;
            $team->telegram = $this->telegram;
            $team->telp = $this->telp;
            $team->sk_pic = $fileSkPic ?? $team->sk_pic;
            $team->avatar = $fileAvatar ?? $team->avatar;
            $team->save();
            $this->reset(['name', 'email', 'avatar', 'telegram', 'telp', 'sk_pic']);
            $this->emit('getTeam');
            $this->emit('closeModalEditTeam');
            $this->alert('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            $this->alert('error', App::environment('local') ? $e->getMessage() : 'Terjadi Kesalahan', [
                'position' =>  'center',
                'timeout' =>  '',
                'toast' =>  false,
                'confirmButtonText' => 'Tutup'
            ]);
        }
    }
}
