<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use App\Models\Workshop;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Redirect;

class DaftarWorkshop extends Component
{
    use LivewireAlert;
    public $workshop_id;
    public $jmlForm = 1;
    public $teams = [];
    public $listHarga = [];
    public $peserta = [], $peserta_id = [];
    public $baju = [];
    public $harga = [];
    public $nama = [];
    public $jenis_kelamin = [];
    public $email = [];
    public $telp = [];

    public $snapToken;
    protected $listeners = ['openModalWorkshop' => 'openModal', 'updateSnapToken' => 'updateSnapToken', 'batalDaftar' => 'batalDaftar'];
    public function render()
    {
        return view('livewire.profile.daftar-workshop');
    }

    public function tambahForm()
    {
        $this->jmlForm++;
    }

    public function hapusForm($index)
    {
        unset($this->peserta[$index]);
        unset($this->baju[$index]);
        unset($this->harga[$index]);
        unset($this->nama[$index]);
        unset($this->jenis_kelamin[$index]);
        unset($this->email[$index]);
        unset($this->telp[$index]);
        $this->jmlForm--;
    }

    public function openModal($id)
    {
        $this->workshop_id = $id;
        // $this->teams = Team::where('user_id', auth()->user()->id)->get();
        $workshop = Workshop::find($id);
        $this->listHarga = $workshop->paket;
        // dd($this->listHarga);
        $this->emit('open-modal-workshop');
    }

    public function simpan()
    {
        $this->validate([
            'harga' => 'required',
            'baju' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required',
            'telp' => 'required',
        ], [
            'harga.required' => 'Pilih paket terlebih dahulu',
            'baju.required' => 'Pilih ukuran baju terlebih dahulu',
            'nama.required' => 'Nama peserta tidak boleh kosong',
            'jenis_kelamin.required' => 'Jenis kelamin peserta tidak boleh kosong',
            'email.required' => 'Email peserta tidak boleh kosong',
            'telp.required' => 'No. Telp peserta tidak boleh kosong',
        ]);

        try {
            $workshop = Workshop::find($this->workshop_id);
            if ($workshop->tgl_sampai <= now()) {
                $this->alert('warning', 'Pendaftaran workshop sudah berakhir');
                return;
            }
            $jmlTransaction = $workshop->transaction()->where('stts', 'dibayar')->count();
            if ($jmlTransaction >= $workshop->kuota) {
                $this->alert('warning', 'Kuota workshop sudah penuh');
                return;
            }
            $fasyankes = \App\Models\Fasyankes::where('user_id', auth()->user()->id)->first();
            if (!$fasyankes) {
                $this->alert('warning', 'Lengkapi data fasyankes terlebih dahulu');
                return;
            }
            // $cek = \App\Models\Transaction::where('kd_rs', $fasyankes->kode)->where('workshop_id', $this->workshop_id)->first();
            // if ($cek) {
            //     $this->alert('warning', 'Anda sudah terdaftar');
            //     return;
            // }
            $maxTransaction = \App\Models\Transaction::where('created_at', 'like', date('Y-m-d') . '%')->max('order_id');
            $maxTransaction = str_replace('-', '', $maxTransaction);
            $last = substr($maxTransaction, 8, 4);
            $last_no = sprintf("%04d", (int)$last + 1);
            // $rand = rand(000000, 999999);
            $order_id = date('Ymd') . '-' . $last_no;

            DB::beginTransaction();
            $transaksi = \App\Models\Transaction::create([
                'user_id' => auth()->user()->id,
                'workshop_id' => $this->workshop_id,
                'snap_token' => '',
                'order_id' => $order_id,
                'nama_rs' => $fasyankes->nama,
                'kd_rs' => $fasyankes->kode,
                'kepemilikan_rs' => 'Pemerintah',
                'provinsi_id' => $fasyankes->provinsi_id,
                'kabupaten_id' => $fasyankes->kabupaten_id,
            ]);
            $item_details = array();
            $producs = array();
            $pesanan = array();
            $ttl = 0;
            for ($key = 0; $key < $this->jmlForm; $key++) {
                // $peserta = Team::find($value);
                $paket = $workshop->paket()->where('id', $this->harga[$key])->first();
                $paketHarga = $paket->harga;
                $paketNama = $paket->nama;
                $transaksi->peserta()->create([
                    'nama' => Str::upper($this->nama[$key]),
                    'jns_kelamin' => $this->jenis_kelamin[$key],
                    'email' => Str::lower($this->email[$key]),
                    'telp' => $this->telp[$key],
                    'baju' => $this->baju[$key],
                    'paket' => $paketNama,
                    'harga' => $paketHarga,
                ]);
                $item_details[] = [
                    'id' => $paket->id,
                    'price' => $paketHarga,
                    'quantity' => 1,
                    'name' => Str::upper($this->nama[$key]) . ' - ' . $paketNama,
                ];
                $producs[] = [
                    'name' => Str::upper($this->nama[$key]),
                    'description' => $paketNama,
                    'price' => $paketHarga,
                    'quantity' => 1,
                ];
                $pesanan[] = [
                    'nama' => Str::upper($this->nama[$key]),
                    'pesanan' => $paketNama,
                    'jml' => 1,
                    'harga' => $paketHarga,
                ];
                $ttl += $paketHarga;
            }
            // $this->alert('success', 'Berhasil mendaftar');

            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = config('midtrans.isProduction', false);
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = config('midtrans.isSanitized', true);
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = config('midtrans.is3ds', true);

            $params = array(
                'transaction_details' => array(
                    'order_id' => $order_id,
                    'gross_amount' => $ttl,
                ),
                'item_details' => $item_details,
                'customer_details' => array(
                    'first_name' => Str::upper($fasyankes->nama),
                    'email' => $fasyankes->email,
                    'phone' => $fasyankes->telp,
                ),
            );

            $transactionSnap = \Midtrans\Snap::createTransaction($params);
            $this->snapToken = $transactionSnap->token;
            $transaksi->snap_token = $this->snapToken;
            $transaksi->save();
            DB::commit();

            return Redirect::to($transactionSnap->redirect_url);
            // $this->emit('open-modal-snap', ['snapToken' => $this->snapToken, 'order_id' => $order_id]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', 'Gagal mendaftar', [
                'position' =>  'center',
                'toast' =>  false,
                'timer' =>  '',
                'confirmButtonText' => 'Tutup',
                'text' => App::environment('local') ? $e->getMessage() : 'Terjadi Kesalahan'
            ]);
        }
    }

    public function updateSnapToken($order_id, $snapToken)
    {
        $this->emit('load-riwayat-workshop');
        $this->emit('close-modal-workshop');
        $this->alert('success', 'Berhasil mendaftar');
        // try {
        //     $cek = \App\Models\Transaction::where('order_id', $order_id)->first();
        //     if ($cek) {
        //         $this->alert('warning', 'No Pesanan : ' . $order_id . ' sudah terdaftar');
        //         return;
        //     }
        //     $workshop = Workshop::find($this->workshop_id)->first();
        //     $fasyankes = \App\Models\Fasyankes::where('user_id', auth()->user()->id)->first();
        //     DB::beginTransaction();
        //     $transaksi = \App\Models\Transaction::create([
        //         'user_id' => auth()->user()->id,
        //         'workshop_id' => $this->workshop_id,
        //         'snap_token' => $snapToken,
        //         'order_id' => $order_id,
        //         'nama_rs' => $fasyankes->nama,
        //         'kd_rs' => $fasyankes->kode,
        //         'kepemilikan_rs' => 'Pemerintah',
        //         'provinsi_id' => $fasyankes->provinsi_id,
        //         'kabupaten_id' => $fasyankes->kabupaten_id,
        //     ]);
        //     for ($key = 0; $key < $this->jmlForm; $key++) {
        //         $paket = $workshop->paket()->where('id', $this->harga[$key])->first();
        //         $paketHarga = $paket->harga;
        //         $paketNama = $paket->nama;
        //         $transaksi->peserta()->create([
        //             'nama' => Str::upper($this->nama[$key]),
        //             'jns_kelamin' => $this->jenis_kelamin[$key],
        //             'email' => Str::lower($this->email[$key]),
        //             'telp' => $this->telp[$key],
        //             'baju' => $this->baju[$key],
        //             'paket' => $paketNama,
        //             'harga' => $paketHarga,
        //         ]);
        //     }
        //     DB::commit();
        //     $this->emit('load-riwayat-workshop');
        //     $this->emit('close-modal-workshop');
        //     $this->alert('success', 'Berhasil mendaftar');
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     $this->alert('error', 'Gagal mendaftar', [
        //         'position' =>  'center',
        //         'toast' =>  false,
        //         'timer' =>  '',
        //         'confirmButtonText' => 'Tutup',
        //         'text' => App::environment('local') ? $e->getMessage() : 'Terjadi Kesalahan'
        //     ]);
        // }
    }

    public function batalDaftar($id)
    {
        try {
            $transaksi = \App\Models\Transaction::find($id)->first();
            $transaksi->delete();
            $this->alert('success', 'Pendaftaran dibatalakan');
        } catch (\Exception $e) {
            $this->alert('error', 'Gagal membatalkan pendaftaran', [
                'position' =>  'center',
                'toast' =>  false,
                'timer' =>  '',
                'confirmButtonText' => 'Tutup',
                'text' => App::environment('local') ? $e->getMessage() : 'Terjadi Kesalahan'
            ]);
        }
    }
}
