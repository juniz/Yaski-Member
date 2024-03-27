<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Fasyankes;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Body extends Component
{
    public $kode = '';
    public $nama = '';
    public $jenis = '';
    public $kelas = '';
    public $alamat = '';
    public $email = '';
    public $telp = '';
    public $direktur = '';

    protected $listeners = ['load-fasyankes' => 'load'];

    public function render()
    {
        return view('livewire.profile.body');
    }

    public function load()
    {
        $user = auth()->user();
        $fasyankes = Fasyankes::where('user_id', $user->id)->first();
        $this->kode = $fasyankes->kode;
        $this->nama = $fasyankes->nama;
        $this->jenis = $fasyankes->jenis;
        $this->kelas = $fasyankes->kelas;
        $this->alamat = $fasyankes->alamat;
        $this->email = $fasyankes->email;
        $this->telp = $fasyankes->telp;
        $this->direktur = $fasyankes->direktur;
    }
}
