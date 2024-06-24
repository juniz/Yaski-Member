<?php

use App\Http\Controllers\CertifikatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Invoice\Transaction;
use App\Http\Controllers\PaymentCallbackController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
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

// Auth::routes();

Auth::routes(['verify' => true]);
//Language Translation
// Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

// Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//workshop
Route::resource('workshops', App\Http\Controllers\WorkshopController::class);

//sub-user
Route::resource('sub-users', App\Http\Controllers\SubUserController::class);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [App\Http\Controllers\ProfileController::class, 'index'])->name('root');
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
    Route::get('/workshop/{id}/hadir', [App\Http\Controllers\PendaftaranController::class, 'daftarHadir'])->name('workshop.daftar.hadir');
    Route::get('/paklaring-cek', [App\Http\Controllers\Api\PaklaringController::class, 'cekPic'])->name('paklaring.cek-pic');
    Route::get('/workshop/sertifikat/{id}', function ($id) {
        return view('workshops.sertifikat', compact('id'));
    })->name('workshop.sertifikat');
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
});

Route::get('/get-kabupaten/{id}', [App\Http\Controllers\ProfileController::class, 'getKabupaten'])->name('getKabupaten');
Route::get('/workshop', fn () => view('workshops.daftar'))->name('workshop.list');
Route::get('/workshop/detail/{slug}', fn () => view('workshops.detail'))->name('workshop.detail');
Route::get('/pendaftaran/{id}', [App\Http\Controllers\PendaftaranController::class, 'index'])->name('pendaftaran.index');
Route::post('/pendaftaran', [App\Http\Controllers\PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::post('/transaksi', [App\Http\Controllers\PendaftaranController::class, 'createSnapToken'])->name('pendaftaran.transaksi');
Route::get('/transaksi-sukses', fn () => view('workshops.transaction-success'))->name('pendaftaran.success');

// Route::get('/email/verify', function () {
//     return view('auth.verify');
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();

//     return redirect('/profile');
// })->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Route::middleware('guest')->group(function () {
//     Route::get('/login', fn () => view('auth.login'))->name('login');
//     Route::get('/register', fn () => view('auth.register'))->name('register');
//     Route::get('/forgot-password', fn () => view('auth.forgot-password'))->name('password.request');
//     Route::get('/reset-password/{token}', fn () => view('auth.reset-password'))->name('password.reset');
//     Route::get('/verify-email', fn () => view('auth.verify'))->name('verification.notice');
//     Route::get('/verify-email/{id}/{hash}', fn () => view('auth.verify-email'))->name('verification.verify');
//     Route::get('/confirm-password', fn () => view('auth.confirm-password'))->name('password.confirm');
// });

Route::post('payments/midtrans-notification', [PaymentCallbackController::class, 'receive']);
Route::get('/sertifikat/{id}', [CertifikatController::class, 'formSertifikat']);
Route::post('/sertifikat/{id}', [CertifikatController::class, 'simpanSertifikat'])->name('sertifikat.simpan');
// Route::get('test', fn () => phpinfo());
