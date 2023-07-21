<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Fasyankes;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Body extends Component
{
    public $user, $subUsers, $provinces, $fasyankes, $jenis, $kelas;

    public function mount()
    {
        $this->user = auth()->user();
        // $this->subUsers = $this->user->hasTeams;
        $this->provinces = Province::all();
        $this->fasyankes = Fasyankes::where('user_id', $this->user->id)->first();
        $this->jenis = ['Praktik Mandiri', 'Rumah Sakit', 'Klinik', 'Puskesmas', 'Apotek'];
        $this->kelas = ['-', 'A', 'B', 'C', 'D', 'D Pratama'];
    }

    public function render()
    {
        return view('livewire.profile.body');
    }
}
