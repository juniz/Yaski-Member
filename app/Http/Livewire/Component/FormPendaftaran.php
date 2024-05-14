<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Http\Request;

class FormPendaftaran extends Component
{
    use LivewireAlert;
    public $total = 0, $nama = [], $jml = [], $harga = [];
    public $slug = '';
    public $workshop_id;

    public function mount(Request $request)
    {
        $this->slug = $request->slug;
    }

    public function render()
    {
        $workshop = \App\Models\Workshop::where('slug', $this->slug)->first();
        $this->workshop_id = $workshop->id;
        return view('livewire.component.form-pendaftaran', [
            'workshop' => $workshop
        ]);
    }

    public function tambahTotal($value, $nama, $jml)
    {
        $this->total = $this->total + $value;
        if (!in_array($nama, $this->nama)) {
            array_push($this->nama, $nama);
            array_push($this->jml, $jml);
            array_push($this->harga, $value);
        } else {
            $key = array_search($nama, $this->nama);
            $this->jml[$key] = $jml;
            $this->harga[$key] = $value;
        }
    }

    public function kurangTotal($value, $nama, $jml)
    {
        if ($this->total > 0) {
            $this->total = $this->total - $value;
            if (in_array($nama, $this->nama)) {
                $key = array_search($nama, $this->nama);
                Arr::forget($this->nama, $key);
                Arr::forget($this->jml, $key);
                Arr::forget($this->harga, $key);
            }
        } else {
            $this->total = 0;
        }
    }

    public function simpan()
    {
        if (empty($this->nama)) {
            $this->alert('warning', 'Pilih paket terlebih dahulu');
        } else {
            try {
                $cek = \App\Models\Reservation::where('user_id', auth()->user()->id)->where('workshop_id', $this->workshop_id)->first();
                if ($cek) {
                    $this->alert('warning', 'Anda sudah terdaftar');
                    return;
                }
                $reservation = \App\Models\Reservation::create([
                    'tgl_reservasi' => now(),
                    'status' => 'pesan',
                    'user_id' => auth()->user()->id,
                    'workshop_id' => $this->workshop_id,
                ]);
                foreach ($this->nama as $key => $value) {
                    \App\Models\WorkshopItem::create([
                        'nama' => $value,
                        'jumlah' => $this->jml[$key],
                        'harga' => $this->harga[$key],
                        'reservation_id' => $reservation->id,
                    ]);
                }
                $this->alert('success', 'Pendaftaran berhasil');
                $this->total = 0;
                $this->nama = [];
                $this->jml = [];
                $this->harga = [];
                $this->emit('closeModal');
            } catch (\Exception $e) {
                $this->alert('error', App::environment('production') ? 'Terjadi kesalahan' : $e->getMessage());
            }
        }
    }
}
