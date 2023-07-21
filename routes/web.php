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

Auth::routes();
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

//workshop
Route::resource('workshops', App\Http\Controllers\WorkshopController::class);

//sub-user
Route::resource('sub-users', App\Http\Controllers\SubUserController::class);

//profile
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::post('/update-fasyankes/{id}', [App\Http\Controllers\ProfileController::class, 'updateFasyankes'])->name('updateFasyankes');
Route::get('/get-kabupaten/{id}', [App\Http\Controllers\ProfileController::class, 'getKabupaten'])->name('getKabupaten');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
