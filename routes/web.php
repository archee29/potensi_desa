<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\MapKaLimas;
use App\Http\Controllers\admin\HomeController;
// use App\Http\Controllers\admin\AuthController;
// use App\Http\Controllers\Controller;

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

Route::get('/', function () {
    return view('user.welcome');
});

Auth::routes();

Route::get('/map', [App\Http\livewire\MapKalimas::class, 'render'])->name('map-kalimas');

Route::resource('home', HomeController::class);

Route::controller(OrderController::class)->group(function () {
    Route::get('/orders/{id}', 'show');
    Route::post('/orders', 'store');
});

//dashboard
// Route::resource('home','admin\HomeController');

//lokasi
Route::resource('lokasi','admin\LokasiController' );

//potensi
Route::resource('rumah-ibadah', 'admin\RumahIbadahController');
Route::resource('wisata', 'admin\TempatWisataController');
Route::resource('sekolah','admin\SekolahController');
Route::resource('pasar','admin\PasarController' );

//desa
Route::resource('artikel','admin\ArtikelController');
Route::resource('profile','admin\ProfileController');
Route::resource('pemerintahan','admin\PemerintahanController');
Route::resource('data', 'admin\DataDesaController');

// //lokasi
// Route::resource('lokasi', [App\Http\Controllers\admin\LokasiController::class, 'index'])->name('lokasi');

// //potensi
// Route::resource('rumah-ibadah', [App\Http\Controllers\admin\RumahIbadahController::class, 'index'])->name('rumah-ibadah');
// Route::resource('wisata', [App\Http\Controllers\admin\TempatWisataController::class, 'index'])->name('wisata');
// Route::resource('sekolah', [App\Http\Controllers\admin\SekolahController::class, 'index'])->name('sekolah');
// Route::resource('pasar', [App\Http\Controllers\admin\PasarController::class, 'index'])->name('pasar');

// //desa
// Route::resource('artikel', [App\Http\Controllers\admin\ArtikelController::class, 'index'])->name('artikel');
// Route::resource('profile', [App\Http\Controllers\admin\ProfileController::class, 'index'])->name('profile');
// Route::resource('pemerintahan', [App\Http\Controllers\admin\PemerintahanController::class, 'index'])->name('pemerintahan');
// Route::resource('data', [App\Http\Controllers\admin\DataDesaController::class, 'index'])->name('data');
