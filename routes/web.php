<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Invoice\Transaction;
use App\Http\Controllers\PaymentCallbackController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

// Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
Route::get('/', [App\Http\Controllers\ProfileController::class, 'index'])->name('root');

Route::get('kwitansi', function () {
    return view('pdf.kwitansi');
});

//workshop
Route::resource('workshops', App\Http\Controllers\WorkshopController::class);

//sub-user
Route::resource('sub-users', App\Http\Controllers\SubUserController::class);

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', fn () => view('index'))->name('dashboard');
    //Update User Details
    Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

    //profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::post('/update-fasyankes/{id}', [App\Http\Controllers\ProfileController::class, 'updateFasyankes'])->name('updateFasyankes');
    Route::post('/update-paklaring/{id}', [App\Http\Controllers\ProfileController::class, 'updatePaklaring'])->name('updatePaklaring');

    //members
    Route::resource('members', App\Http\Controllers\MemberController::class);

    Route::get('permissions', [App\Http\Controllers\PermissionController::class, 'index'])->name('permissions.index');

    Route::get('roles', function () {
        return view('admin.roles.index');
    })->name('roles.index');

    Route::get('/list-workshop', fn () => view('admin.workshop.index'))->name('workshop.index');

    Route::get('/workshop/create', fn () => view('workshops.create'))->name('workshop.create');
    Route::post('/workshop/store', [App\Http\Controllers\WorkshopController::class, 'store'])->name('workshop.store');
    Route::get('/workshop/{id}', [App\Http\Controllers\WorkshopController::class, 'show'])->name('workshop.show');
    Route::get('/workshop/{workshop}/edit', [App\Http\Controllers\WorkshopController::class, 'edit'])->name('workshop.edit');
    Route::put('/workshop/{workshop}', [App\Http\Controllers\WorkshopController::class, 'update'])->name('workshop.update');
    Route::get('/paklaring', fn () => view('paklaring.index'))->name('paklaring.index');
    Route::get('/mou', fn () => view('mou.index'))->name('mou.index');
    // Route::resource('pendaftaran', App\Http\Controllers\PendaftaranController::class);

    Route::get('/transaksi/{id}', [App\Http\Controllers\PendaftaranController::class, 'show'])->name('workshop.peserta');
    Route::get('/paklaring-cek', [App\Http\Controllers\Api\PaklaringController::class, 'cekPic'])->name('paklaring.cek-pic');

    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
});

Route::get('/get-kabupaten/{id}', [App\Http\Controllers\ProfileController::class, 'getKabupaten'])->name('getKabupaten');
Route::get('/workshop', fn () => view('workshops.daftar'))->name('workshop.list');
Route::get('/pendaftaran/{id}', [App\Http\Controllers\PendaftaranController::class, 'index'])->name('pendaftaran.index');
Route::post('/pendaftaran', [App\Http\Controllers\PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::post('/transaksi', [App\Http\Controllers\PendaftaranController::class, 'createSnapToken'])->name('pendaftaran.transaksi');
Route::get('/transaksi-sukses', fn () => view('workshops.transaction-success'))->name('pendaftaran.success');

Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => view('auth.login'))->name('login');
    Route::get('/register', fn () => view('auth.register'))->name('register');
    Route::get('/forgot-password', fn () => view('auth.forgot-password'))->name('password.request');
    Route::get('/reset-password/{token}', fn () => view('auth.reset-password'))->name('password.reset');
    Route::get('/verify-email', fn () => view('auth.verify-email'))->name('verification.notice');
    Route::get('/verify-email/{id}/{hash}', fn () => view('auth.verify-email'))->name('verification.verify');
    Route::get('/confirm-password', fn () => view('auth.confirm-password'))->name('password.confirm');
});

Route::post('payments/midtrans-notification', [PaymentCallbackController::class, 'receive']);

Route::get('invoice', function () {
    $data = [
        'costumer' => [
            'name' => 'Yudo',
            'email' => 'yudojuni93@gmail.com',
            'phone' => '08123456789'
        ],
        'product' => [
            'name' => 'Pemrograman',
            'description' => 'Twin Bed',
            'price' => '3500000',
            'quantity' => '1',
        ],

    ];
    $invoice = new Transaction();
    return $invoice->generateInvoice($data)->stream();
});

// Route::get('/test', function () {

//     $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
//     $qr = QrCode::size(300)
//         ->format('png')
//         ->merge('assets/images/logo.png', 0.3, true)
//         ->style('dot')
//         ->eye('circle')
//         ->gradient(255, 0, 0, 0, 0, 255, 'diagonal')
//         ->margin(1)
//         ->errorCorrection('M')
//         ->generate('83745837hfdyeurf');
//     // return response($qr)->header('Content-type', 'image/png');
//     $beautymail->send('emails.welcome', [
//         'name' => 'Yudo',
//         'qr' => $qr,
//         'link' => 'https://yaski.com'
//     ], function ($message) {
//         $message
//             ->from('noreplay@yaski.com')
//             ->to('yudojuni93@gmail.com', 'Yudo')
//             ->subject('Berhasil mendaftar workshop');
//     });
// });

// // Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
// Route::get('/mail', function () {
//     Mail::to('yudojuni93@gmail.com')
//         ->send(new App\Mail\TransactionMail('123', 'Workshop', 'Yudo', 'Pemrograman', '100000', '1', '100000'));
//     // return view('emails.mail');
// })->name('mail');
