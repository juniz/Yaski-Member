<?php

namespace App\Http\Livewire\Component;

use App\Models\Paket;
use Livewire\Component;
use App\Models\Peserta;
use App\Models\Workshop;

class ModalUbahPembayaran extends Component
{
    public $paket;
    public Peserta $peserta;
    public $nama;
    public $harga;
    public $jenis_kelamin;
    public $email;
    public $telp;
    public $nama_paket;

    protected $listeners = ['ubahPeserta' => 'openModal'];

    public function render()
    {
        return view('livewire.component.modal-ubah-pembayaran');
    }

    public function openModal($peserta, $id)
    {
        $this->paket = Workshop::find($id)->paket;
        $this->peserta = Peserta::find($peserta);
        $this->nama = $this->peserta->nama;
        $this->harga = $this->paket->where('nama', $this->peserta->paket)->first()->id;
        // $this->harga = $this->peserta->harga;
        $this->jenis_kelamin = $this->peserta->jns_kelamin;
        $this->email = $this->peserta->email;
        $this->telp = $this->peserta->telp;
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required',
            'harga' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required',
            'telp' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'harga.required' => 'Harga tidak boleh kosong',
            'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'telp.required' => 'Telp tidak boleh kosong',
        ]);

        $paket = $this->paket->where('id', $this->harga)->first();

        $this->peserta->update([
            'nama' => $this->nama,
            'harga' => $this->harga,
            'jns_kelmain' => $this->jenis_kelamin,
            'email' => $this->email,
            'telp' => $this->telp,
            'paket' => $paket->nama,
            'harga' => $paket->harga,
        ]);

        // $this->reset();
        $this->emit('refreshDatatable');
        $this->emit('pembayaranTersimpan');
    }
}
