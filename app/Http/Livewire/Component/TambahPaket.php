<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\Paket;
use Illuminate\Support\Facades\App;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TambahPaket extends Component
{
    use LivewireAlert;
    public $nama, $harga, $idWorkshop, $idPaket;
    public $state;
    protected $listeners = ['openModalHarga' => 'openModal', 'hapusPaket' => 'hapus', 'ubahPaket' => 'ubahModal'];

    public function render()
    {
        return view('livewire.component.tambah-paket');
    }

    public function openModal($id)
    {
        $this->idWorkshop = $id;
        $this->state = 'tambah';
        $this->reset(['nama', 'harga']);
        $this->emit('openPaketModal');
    }

    public function hapus($id)
    {
        try {
            Paket::find($id)->delete();
            $this->emit('refreshWorkshop');
            $this->alert('success', 'Berhasil Menghapus Data');
        } catch (\Exception) {
            $this->alert('error', 'Gagal Menghapus Data');
        }
    }

    public function ubahModal($id)
    {
        $paket = Paket::find($id);
        $this->nama = $paket->nama;
        $this->harga = $paket->harga;
        $this->idPaket = $paket->id;
        $this->state = 'ubah';

        $this->emit('openPaketModal');
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

            if ($this->state == 'tambah') {
                $paket = new Paket();
                $paket->nama = $this->nama;
                $paket->harga = $this->harga;
                $paket->workshop_id = $this->idWorkshop;
                $paket->save();
            } else {
                $paket = Paket::find($this->idPaket);
                $paket->nama = $this->nama;
                $paket->harga = $this->harga;
                $paket->save();
            }

            $this->alert('success', 'Berhasil Menyimpan Data', [
                'position' =>  'top-end',
                'timer' =>  3000,
                'toast' =>  true,
                'text' =>  '',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);

            $this->reset(['nama', 'harga']);
            $this->emit('refreshWorkshop');

            $this->emit('closePaketModal');
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
