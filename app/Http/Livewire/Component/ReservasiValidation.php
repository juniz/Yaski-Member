<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\Reservation;
use Illuminate\Support\Facades\App;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ReservasiValidation extends Component
{
    use WithFileUploads, LivewireAlert;
    public $idWorkshop, $idReservation, $bukti;
    protected $listeners = ['refreshReservasi' => '$refresh'];
    public function mount($idWorkshop)
    {
        $this->idWorkshop = $idWorkshop;
    }

    public function render()
    {
        return view('livewire.component.reservasi-validation', [
            'reservasi' => Reservation::where('status', '<>', 'batal')->where('workshop_id', $this->idWorkshop)->first()
        ]);
    }

    public function simpan()
    {
        $this->validate([
            'bukti' => 'required|image|max:1024'
        ], [
            'bukti.required' => 'Bukti pembayaran tidak boleh kosong',
            'bukti.image' => 'Bukti pembayaran harus berupa gambar',
            'bukti.max' => 'Bukti pembayaran tidak boleh lebih dari 1MB'
        ]);

        try {

            $this->idReservation = Reservation::where('status', '<>', 'batal')->where('workshop_id', $this->idWorkshop)->first()->id;

            $fileName = 'reservation-' . auth()->user()->name . '-' . time() . '.' . $this->bukti->extension();
            $this->bukti->storeAs('public/reservation', $fileName);

            $reservation = Reservation::where('id', $this->idReservation);
            if ($reservation->first()->status == 'selesai' || $reservation->first()->status == 'batal') {
                $this->alert('warning', 'Reservasi sudah selesai atau dibatalkan');
                return;
            }
            $reservation->update([
                'status' => 'proses',
                'tgl_confirm' => now(),
                'file_bukti' => $fileName
            ]);

            $this->alert('success', 'Berhasil mengirim bukti pembayaran');
            $this->reset(['bukti']);
            $this->emit('refreshReservasi');
        } catch (\Exception $e) {

            $this->alert('error', App::environment('local') ? $e->getMessage() : 'Terjadi kesalahan');
        }
    }
}
