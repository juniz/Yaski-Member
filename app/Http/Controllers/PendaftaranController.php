<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Transaction;
use App\Models\Workshop;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionMail;
use App\Invoice\Transaction as InvoiceTransaction;
use App\Jobs\SendMailTransaction;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

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

        try {
            DB::beginTransaction();
            $transaksi = Transaction::create([
                'workshop_id' => $request['workshop']['id'],
                'snap_token' => $request['data']['snap_token'],
                'order_id' => $request['data']['order_id'],
                // 'nama' => Str::upper($request['data']['nama']),
                // 'jns_kelamin' => $request['data']['jns_kelamin'],
                // 'email' => $request['data']['email'],
                // 'telp' => $request['data']['telp'],
                'nama_rs' => $request['data']['nama_rs'],
                'kd_rs' => $request['data']['kd_rs'],
                'kepemilikan_rs' => $request['data']['kepemilikan_rs'],
                'provinsi_id' => $request['data']['provinsi_id'],
                'kabupaten_id' => $request['data']['kabupaten_id'],
                // 'ukuran_baju' => $request['data']['ukuran_baju'],
                // 'paket' => $request['data']['paket'],
                // 'harga' => $request['data']['harga'],
            ]);

            \App\Models\Peserta::create([
                'nama' => Str::upper($request['data']['nama']),
                'jns_kelamin' => $request['data']['jns_kelamin'],
                'email' => $request['data']['email'],
                'telp' => $request['data']['telp'],
                'transaction_id' => $transaksi->id,
                'baju' => $request['data']['ukuran_baju'],
                'paket' => $request['data']['paket'],
                'harga' => $request['data']['harga'],
            ]);

            // $qr = $this->generateQrCode($snapToken);

            // $beautymail = app()->make(Beautymail::class);
            // $qr = QrCode::size(300)
            //     ->format('png')
            //     ->merge('assets/images/logo.png', 0.3, true)
            //     ->style('dot')
            //     ->eye('circle')
            //     ->gradient(255, 0, 0, 0, 0, 255, 'diagonal')
            //     ->margin(1)
            //     ->errorCorrection('M')
            //     ->generate($snapToken);
            // return response($qr)->header('Content-type', 'image/png');
            // $beautymail->send('emails.welcome', [
            //     'name' => $request->nama,
            //     'qr' => $qr,
            // ], function ($message) use ($request) {
            //     $message
            //         ->from('noreplay@yaski.com')
            //         ->to($request->email, $request->nama)
            //         ->subject('Berhasil mendaftar workshop');
            // });

            // $workshop = Workshop::find($request->workshop_id)->first();

            $invoice = new InvoiceTransaction();
            $data = [
                'order_id' => $request['data']['order_id'],
                'file_name' => $request['data']['order_id'],
                'costumer' => [
                    'name' => $request['data']['nama'],
                    'email' => $request['data']['email'],
                    'phone' => $request['data']['telp'],
                ],
                'product' => [
                    'name' => $request['workshop']['nama'],
                    'description' => $request['data']['paket'],
                    'price' => $request['data']['harga'],
                    'quantity' => 1,
                ],
            ];
            $invoice->generateInvoice($data);

            $params = [
                'order_id' => $request['data']['order_id'],
                'email' => $request['data']['email'],
                'workshop' => $request['workshop']['nama'],
                'nama' => $request['data']['nama'],
                'pesanan' => $request['data']['paket'],
                'total' => $request['data']['harga'],
                'jml' => 1,
                'harga' => $request['data']['harga'],
                // 'pdf' => storage_path('app/public/invoices/' . $request['data']['order_id'] . '.pdf'),
                // 'qr' => $qr,
                'invoice' =>  $request['data']['order_id'] . '.pdf',
            ];

            dispatch(function () use ($params) {
                Mail::to($params['email'])
                    ->send(new TransactionMail($params));
            });
            DB::commit();
            return response()->json([
                'status' => 'success',
                // 'snap_token' => $request->snap_token,
                'message' => 'Pendaftaran berhasil',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Pendaftaran gagal',
                'data' => $request->all(),
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

    public function daftarHadir($id)
    {
        return view('workshops.daftar-hadir', compact('id'));
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
            'email' => 'required|email',
            'telp' => 'required|numeric',
            'pribadi' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'harga' => 'required',
            // 'baju' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah terdaftar',
            'telp.required' => 'Nomor telepon tidak boleh kosong',
            'pribadi.required' => 'Pilih salah satu',
            'kepemilikan_rs.required_if' => 'Pilih salah satu',
            'provinsi.required' => 'Provinsi tidak boleh kosong',
            'kabupaten.required' => 'Kabupaten tidak boleh kosong',
            'harga.required' => 'Harga tidak boleh kosong',
            // 'baju.required' => 'Pilih salah satu',
        ]);

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.isProduction', false);
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized', true);
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is3ds', true);

        try {
            $workshop = Workshop::find($request->workshop_id);
            if ($workshop->tgl_sampai <= now()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Workshop sudah berakhir',
                ]);
            }
            $jmlTransaction = $workshop->transaction()->where('stts', 'dibayar')->count();
            if ($jmlTransaction >= $workshop->kuota) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kuota workshop sudah penuh',
                ]);
            }
            $paket = $workshop->paket()->where('id', $request->harga)->first();
            $harga = $paket->harga;
            $paket = $paket->nama;
            $maxTransaction = \App\Models\Transaction::where('created_at', 'like', date('Y-m-d') . '%')->max('order_id');
            $maxTransaction = str_replace('-', '', $maxTransaction);
            $last = substr($maxTransaction, 8, 4);
            $last_no = sprintf("%04d", (int)$last + 1);
            // $last_no = sprintf("%04d", $workshop->count() + 1);
            // $last_no = rand(100000, 999999);
            $order_id = date('Ymd') . '-' . $last_no;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $order_id,
                    'gross_amount' => $harga,
                ),
                'item_details' => array(
                    array(
                        'id' => $request->workshop_id,
                        'price' => $harga,
                        'quantity' => 1,
                        'name' => $paket,
                    ),
                ),
                'customer_details' => array(
                    'first_name' => Str::upper($request->nama),
                    'email' => $request->email,
                    'phone' => $request->telp,
                ),
            );

            $snapToken = \Midtrans\Snap::createTransaction($params);
            // dd($snapToken);

            DB::beginTransaction();
            $transaksi = Transaction::create([
                'workshop_id' => $workshop->id,
                'snap_token' => $snapToken->token,
                'order_id' => $order_id,
                'nama_rs' => $request->nama_rs,
                'kd_rs' => $request->kode_rs,
                'kepemilikan_rs' => $request->kepemilikan_rs,
                'provinsi_id' => $request->provinsi,
                'kabupaten_id' => $request->kabupaten,
            ]);

            \App\Models\Peserta::create([
                'nama' => Str::upper($request->nama),
                'jns_kelamin' => $request->jenis_kelamin,
                'email' => Str::lower($request->email),
                'telp' => $request->telp,
                'transaction_id' => $transaksi->id,
                'baju' => $request->baju ?? 'XL',
                'paket' => $paket,
                'harga' => $harga,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken->redirect_url,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => App::environment('local') ? $e->getMessage() : 'Terjadi kesalahan saat membuat transaksi ' . $order_id,
            ], 500);
        }
    }
}
