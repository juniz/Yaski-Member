<?php

namespace App\Http\Livewire\Admin\Workshop;

use Livewire\Component;
use App\Models\Workshop;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use WithFileUploads, LivewireAlert;
    public $nama, $gambar, $tgl_mulai, $tgl_selesai, $lat, $lng;
    protected $listeners = [
        'createModal' => 'createModal'
    ];
    public function render()
    {
        return view('livewire.admin.workshop.create');
    }

    public function createModal()
    {
        $this->dispatchBrowserEvent('createModal');
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required',
            'gambar' => 'required|image|mimes:png,jpg,jpeg',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'lat' => 'required',
            'lng' => 'required'
        ], [
            'nama.required' => 'Nama workshop tidak boleh kosong',
            'gambar.required' => 'Gambar workshop tidak boleh kosong',
            'gambar.image' => 'Gambar workshop harus berupa gambar',
            'gambar.mimes' => 'Gambar workshop harus berupa png, jpg, jpeg',
            'tgl_mulai.required' => 'Tanggal mulai workshop tidak boleh kosong',
            'tgl_selesai.required' => 'Tanggal selesai workshop tidak boleh kosong',
            'lat.required' => 'Latitude workshop tidak boleh kosong',
            'lng.required' => 'Longitude workshop tidak boleh kosong'
        ]);

        try {
            $file_name = $this->nama . '-' . time() . '.' . $this->gambar->extension();
            $gambar = $this->gambar->storeAs('public/workshop', $file_name);
            Workshop::create([
                'nama' => $this->nama,
                'gambar' => $file_name,
                'tgl_mulai' => $this->tgl_mulai,
                'tgl_selesai' => $this->tgl_selesai,
                'lat' => $this->lat,
                'lng' => $this->lng
            ]);
            $this->reset(['nama', 'gambar', 'tgl_mulai', 'tgl_selesai', 'lat', 'lng']);
            $this->emit('refreshWorkshop');
            $this->dispatchBrowserEvent('closeModalTambah');
            $this->alert('success', 'Berhasil menyimpan data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        } catch (\Exception $e) {
            // $this->dispatchBrowserEvent('closeModal');
            $this->alert('error', $e->getMessage(), [
                'position' =>  'center',
                'toast' =>  false
            ]);
        }
    }
}
