<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use App\Models\Peserta;
use App\Models\Transaction;

class RiwayatWorkshop extends Component
{
    public $transactions = [];
    protected $listeners = ['load-riwayat-workshop' => 'getWorkshop'];
    public function render()
    {
        return view('livewire.profile.riwayat-workshop');
    }

    public function getWorkshop()
    {
        $fasyankes = \App\Models\Fasyankes::where('user_id', auth()->user()->id)->first();
        $this->transactions = Transaction::where('kd_rs', $fasyankes->kode ?? '-')->get();
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
