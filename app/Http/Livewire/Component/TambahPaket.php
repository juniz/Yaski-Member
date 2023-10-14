<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\Paket;
use Illuminate\Support\Facades\App;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TambahPaket extends Component
{
    use LivewireAlert;
    public $nama, $harga;
    public function render()
    {
        return view('livewire.component.tambah-paket', [
            'pakets' => Paket::all()
        ]);
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required',
            'harga' => 'required'
        ], [
            'nama.required' => 'Nama Paket tidak boleh kosong',
            'harga.required' => 'Harga Paket tidak boleh kosong'
        ]);

        try {

            $paket = new Paket();
            $paket->nama = $this->nama;
            $paket->harga = $this->harga;
            $paket->save();

            $this->alert('success', 'Berhasil Menyimpan Data', [
                'position' =>  'top-end',
                'timer' =>  3000,
                'toast' =>  true,
                'text' =>  '',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);

            $this->nama = '';
            $this->harga = '';

            $this->dispatchBrowserEvent('closePaketModal');
        } catch (\Exception $e) {
            $this->alert('error', 'Gagal Menyimpan Data', [
                'position' =>  'center',
                'toast' =>  false,
                'text' =>  App::environment('local') ? $e->getMessage() : '',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  true,
            ]);
        }
    }
}
