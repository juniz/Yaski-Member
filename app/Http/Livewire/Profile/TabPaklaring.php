<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use App\Models\Paklaring;
use App\Models\Team;

class TabPaklaring extends Component
{
    public $sttsPaklaring = false;
    public $sttsMou = false;
    protected $listeners = ['cekPaklaring' => 'cekPaklaring'];
    public function render()
    {
        return view('livewire.profile.tab-paklaring');
    }

    public function cekPaklaring()
    {
        $data = Team::where('user_id', auth()->user()->id)->count();
        if ($data > 0) {
            $this->sttsPaklaring = true;
        } else {
            $this->sttsPaklaring = false;
        }
        $data = Paklaring::where('user_id', auth()->user()->id)->where('stts', 'disetujui')->first();
        if ($data) {
            $this->sttsMou = true;
        } else {
            $this->sttsMou = false;
        }
    }
}
