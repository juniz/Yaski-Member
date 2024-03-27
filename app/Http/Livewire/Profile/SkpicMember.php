<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\App;

class SkpicMember extends Component
{
    use LivewireAlert;
    public $sk_pic;
    protected $listeners = ['getSk' => 'getSk'];
    public function render()
    {
        return view('livewire.profile.skpic-member');
    }

    public function getSk($id)
    {
        try {
            $team = \App\Models\Team::find($id);
            // dd($id);
            $this->sk_pic = $team->sk_pic;
            $this->emit('openModalSkpic');
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
