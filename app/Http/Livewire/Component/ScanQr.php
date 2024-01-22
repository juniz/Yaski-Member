<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ScanQr extends Component
{
    use LivewireAlert;
    public $transaction;
    protected $listeners = ['transaction-set' => 'setTransaction', 'get-transaction' => 'getTransaction'];
    public function render()
    {
        return view('livewire.component.scan-qr');
    }

    public function setTransaction($id)
    {
        $this->transaction = $id;
    }

    public function getTransaction()
    {
        try {

            $transaction = \App\Models\Transaction::where('id', $this->transaction)->first();
            $transaction->stts = 'hadir';
            $transaction->save();

            $this->alert('success', 'Berhasil update status');
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
