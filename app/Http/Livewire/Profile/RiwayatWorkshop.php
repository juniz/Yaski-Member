<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use App\Models\Peserta;
use App\Models\Sertifikat;
use App\Models\Transaction;

class RiwayatWorkshop extends Component
{
    public $transactions = [];
    public $selectedWorkshop = null;
    public $selectedTransaction = null;
    public $selectedSertifikats = [];
    protected $listeners = ['load-riwayat-workshop' => 'getWorkshop'];

    public function render()
    {
        return view('livewire.profile.riwayat-workshop');
    }

    public function showMateri($workshopId)
    {
        $this->selectedWorkshop = \App\Models\Workshop::with('materials')->find($workshopId);
        $this->dispatchBrowserEvent('openMateriModal');
    }

    public function showSertifikat($transactionId)
    {
        $this->selectedTransaction = Transaction::with(['workshop', 'peserta'])->find($transactionId);

        if (!$this->selectedTransaction) {
            $this->selectedSertifikats = collect();
            $this->dispatchBrowserEvent('openSertifikatModal');
            return;
        }

        $pesertaIds = $this->selectedTransaction->peserta->pluck('id');
        $this->selectedSertifikats = Sertifikat::with('peserta')
            ->where('workshop_id', $this->selectedTransaction->workshop_id)
            ->whereIn('peserta_id', $pesertaIds)
            ->orderBy('no_urut')
            ->get();

        $this->dispatchBrowserEvent('openSertifikatModal');
    }

    public function getWorkshop()
    {
        $fasyankes = \App\Models\Fasyankes::where('user_id', auth()->user()->id)->first();
        $this->transactions = Transaction::with(['workshop.materials', 'peserta'])
            ->where('kd_rs', $fasyankes->kode ?? '-')
            ->where('stts', 'dibayar')
            ->get();
    }

    public function bayar($id)
    {
        try {
            $transaction = Transaction::find($id);
            $peserta = Peserta::where('transaction_id', $id)->get();
            $peserta->each(function ($p) {
                $p->update(['transaction_id' => null]);
            });
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }
}
