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
    public $slug;
    public $completionProgress = 0;
    public $completionItems = [];
    public $isProfileComplete = false;

    protected $listeners = ['load-alert' => 'load'];

    public function mount($fasyankes)
    {
        $this->fasyankes = $fasyankes;
        $this->loadCompletionProgress();
    }

    public function render()
    {
        return view('livewire.profile.alert');
    }

    public function load()
    {
        $this->loadCompletionProgress();

        $team = Team::where('user_id', auth()->user()->id)->count();
        $workshop = Workshop::where('stts', '1')->first();
        if ($workshop) {
            if ($team > 0) {
                $this->workshop_id = $workshop->id ?? '';
                $this->slug = $workshop->slug ?? '';
                $transaction = Transaction::where('workshop_id', $this->workshop_id)
                    ->where('kd_rs', $this->fasyankes->kode ?? '-')
                    ->first();
                if (empty($transaction)) {
                    session()->flash('message', 'Anda belum terdaftar di workshop ' . $workshop->nama . '<br> Silahkan melakukan pendaftaran disini.');
                    session()->flash('type', 'info');
                }
            }
        }
    }

    public function openPicModal()
    {
        $this->dispatchBrowserEvent('openModalTeam');
    }

    private function loadCompletionProgress()
    {
        $fasyankesFields = [
            'nama',
            'jenis',
            'telp',
            'email',
            'direktur',
            'alamat',
            'provinsi_id',
            'kabupaten_id',
        ];

        $isFasyankesComplete = !empty($this->fasyankes);
        foreach ($fasyankesFields as $field) {
            if (empty($this->fasyankes->{$field})) {
                $isFasyankesComplete = false;
                break;
            }
        }

        $isPicComplete = Team::where('user_id', auth()->id())
            ->whereNotNull('name')
            ->whereNotNull('email')
            ->whereNotNull('telp')
            ->whereNotNull('telegram')
            ->whereNotNull('sk_pic')
            ->exists();

        $this->completionItems = [
            [
                'label' => 'Data Fasyankes',
                'complete' => $isFasyankesComplete,
                'action' => 'fasyankes',
            ],
            [
                'label' => 'Data PIC',
                'complete' => $isPicComplete,
                'action' => 'pic',
            ],
        ];

        $completed = collect($this->completionItems)->where('complete', true)->count();
        $this->completionProgress = (int) round(($completed / count($this->completionItems)) * 100);
        $this->isProfileComplete = $this->completionProgress === 100;
    }
}
