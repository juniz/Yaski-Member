<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\Workshop;
use App\Models\Team;

class Alert extends Component
{
    public $fasyankes;
    public $workshop_id;
    protected $listeners = ['load-alert' => 'load'];

    public function mount($fasyankes)
    {
        $this->fasyankes = $fasyankes;
    }

    public function render()
    {
        return view('livewire.profile.alert');
    }

    public function load()
    {
        $team = Team::where('user_id', auth()->user()->id)->count();
        if ($team > 0) {
            $workshop = Workshop::latest()->first();
            $this->workshop_id = $workshop->id;
            $transaction = Transaction::where('workshop_id', $workshop->id)->where('kd_rs', $this->fasyankes->kode)->first();
            if (empty($transaction)) {
                session()->flash('message', 'Anda belum terdaftar di workshop ' . $workshop->nama . '<br> Silahkan melakukan pendaftaran disini.');
                session()->flash('type', 'info');
            }
        }
    }
}
