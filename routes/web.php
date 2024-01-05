<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    Route::get('/get-kabupaten/{id}', [App\Http\Controllers\ProfileController::class, 'getKabupaten'])->name('getKabupaten');
    Route::post('/update-paklaring/{id}', [App\Http\Controllers\ProfileController::class, 'updatePaklaring'])->name('updatePaklaring');

    //members
    Route::resource('members', App\Http\Controllers\MemberController::class);

    Route::get('permissions', [App\Http\Controllers\PermissionController::class, 'index'])->name('permissions.index');

    Route::get('roles', function () {
        return view('admin.roles.index');
    })->name('roles.index');

    Route::get('/list-workshop', fn () => view('admin.workshop.index'))->name('workshop.index');
    Route::get('/workshop', fn () => view('workshops.daftar'))->name('workshop.list');
    Route::get('/workshop/create', fn () => view('workshops.create'))->name('workshop.create');
    Route::post('/workshop/store', [App\Http\Controllers\WorkshopController::class, 'store'])->name('workshop.store');
    Route::get('/workshop/{id}', [App\Http\Controllers\WorkshopController::class, 'show'])->name('workshop.show');
    Route::get('/workshop/{workshop}/edit', [App\Http\Controllers\WorkshopController::class, 'edit'])->name('workshop.edit');
    Route::put('/workshop/{workshop}', [App\Http\Controllers\WorkshopController::class, 'update'])->name('workshop.update');
    Route::get('/paklaring', fn () => view('paklaring.index'))->name('paklaring.index');
});

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
