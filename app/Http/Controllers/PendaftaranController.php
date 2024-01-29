<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Transaction;
use App\Models\Workshop;
use App\Notifications\TransactionMail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $workshop = Workshop::find(Crypt::decrypt($id));
        $provinces = Province::all();
        return view('workshops.pendaftaran', compact('provinces', 'workshop'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'workshop_id' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required|email|unique:transaction,email',
            'telp' => 'required',
            'pribadi' => 'required',
            'nama_rs' => 'required_if:pribadi,rs',
            'kode_rs' => 'required_if:pribadi,rs|unique:transaction,kd_rs',
            'kepemilikan_rs' => 'required_if:pribadi,rs',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'harga' => 'required',
            'baju' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah terdaftar',
            'telp.required' => 'Nomor telepon tidak boleh kosong',
            'pribadi.required' => 'Pilih salah satu',
            'nama_rs.required_if' => 'Nama rumah sakit tidak boleh kosong',
            'kode_rs.required_if' => 'Kode rumah sakit tidak boleh kosong',
            'kode_rs.unique' => 'Kode rumah sakit sudah terdaftar',
            'kepemilikan_rs.required_if' => 'Pilih salah satu',
            'provinsi.required' => 'Provinsi tidak boleh kosong',
            'kabupaten.required' => 'Kabupaten tidak boleh kosong',
            'harga.required' => 'Harga tidak boleh kosong',
            'baju.required' => 'Pilih salah satu',
        ]);

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        try {
            $paket = Workshop::find($request->workshop_id)->paket()->where('id', $request->harga)->first();
            $harga = $paket->harga;
            $paket = $paket->nama;

            $params = array(
                'transaction_details' => array(
                    'order_id' => rand(),
                    'gross_amount' => $harga,
                ),
                'customer_details' => array(
                    'first_name' => $request->nama,
                    'email' => $request->email,
                    'phone' => $request->telp,
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $transaction = Transaction::create([
                'workshop_id' => $request->workshop_id,
                'snap_token' => $snapToken,
                'nama' => $request->nama,
                'jns_kelamin' => $request->jenis_kelamin,
                'email' => $request->email,
                'telp' => $request->telp,
                'nama_rs' => $request->nama_rs,
                'kd_rs' => $request->kode_rs,
                'kepemilikan_rs' => $request->kepemilikan_rs,
                'provinsi_id' => $request->provinsi,
                'kabupaten_id' => $request->kabupaten,
                'ukuran_baju' => $request->baju,
                'paket' => $paket,
                'harga' => $harga,
            ]);

            $qr = $this->generateQrCode($snapToken);

            $payloads = array(
                'nama' => $request->nama,
                'email' => $request->email,
                'qr' => $qr,
            );

            dispatch(new \App\Jobs\SendMailTransaction($payloads));

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'message' => 'Pendaftaran berhasil',
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'error : ' . $e->getMessage() . 'Line : ' . $e->getLine() . 'File : ' . $e->getFile(),
                'data' => $transaction,
            ], 500);
        }
    }

    public function generateQrCode($data)
    {
        return QrCode::size(300)
            ->format('png')
            ->merge('assets/images/logo.png', 0.3, true)
            ->errorCorrection('M')
            ->generate($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('workshops.index', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function createSnapToken(Request $request)
    {
        $this->validate($request, [
            'workshop_id' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required|email|unique:transaction,email',
            'telp' => 'required',
            'pribadi' => 'required',
            'nama_rs' => 'required_if:pribadi,rs',
            'kode_rs' => 'required_if:pribadi,rs|unique:transaction,kd_rs',
            'kepemilikan_rs' => 'required_if:pribadi,rs',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'harga' => 'required',
            'baju' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah terdaftar',
            'telp.required' => 'Nomor telepon tidak boleh kosong',
            'pribadi.required' => 'Pilih salah satu',
            'nama_rs.required_if' => 'Nama rumah sakit tidak boleh kosong',
            'kode_rs.required_if' => 'Kode rumah sakit tidak boleh kosong',
            'kode_rs.unique' => 'Kode rumah sakit sudah terdaftar',
            'kepemilikan_rs.required_if' => 'Pilih salah satu',
            'provinsi.required' => 'Provinsi tidak boleh kosong',
            'kabupaten.required' => 'Kabupaten tidak boleh kosong',
            'harga.required' => 'Harga tidak boleh kosong',
            'baju.required' => 'Pilih salah satu',
        ]);

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        try {
            $paket = Workshop::find($request->workshop_id)->paket()->where('id', $request->harga)->first();
            $harga = $paket->harga;
            $paket = $paket->nama;

            $params = array(
                'transaction_details' => array(
                    'order_id' => rand(),
                    'gross_amount' => $harga,
                ),
                'customer_details' => array(
                    'first_name' => $request->nama,
                    'email' => $request->email,
                    'phone' => $request->telp,
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'data' => $request->all(),
                'message' => 'Pendaftaran berhasil',
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
