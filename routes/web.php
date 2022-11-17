<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\MapKaLimas;
// use Illminate\Support\Facades\Auth;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\LokasiController;
use App\Http\Controllers\admin\RumahIbadahController;
use App\Http\Controllers\admin\TempatWisataController;
use App\Http\Controllers\admin\SekolahController;
use App\Http\Controllers\admin\PasarController;
use App\Http\Controllers\admin\ArtikelController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\PemerintahanController;
use App\Http\Controllers\admin\DataDesaController;
use App\Http\Controllers\admin\DataController;


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

// aa
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/map',[App\Http\Controllers\MapController::class,'index'])->name('map.index');



// Route::get('/map', [App\Http\livewire\MapKalimas::class, 'render'])->name('map-kalimas');



//dashboard
Route::resource('home', HomeController::class);



//lokasi
Route::controller(LokasiController::class)->group(function () {
    Route::get('/lokasi/data', [DataController::class, 'lokasi'])->name('data-lokasi');
    Route::resource('lokasi', (LokasiController::class));
    Route::get('lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
    Route::post('lokasi/create', [LokasiController::class, 'create'])->name('lokasi.create');
    Route::put('lokasi/edit/{id}', [LokasiController::class, 'edit'])->name('lokasi.edit');
    Route::get('lokasi/show/{id}', [LokasiController::class, 'show'])->name('lokasi.show');
});


// Potensi

Route::controller(RumahIbadahController::class)->group(function () {
    Route::get('/rumah-ibadah', 'index');
    Route::get('/rumah-ibadah/create', 'create');
    Route::get('/rumah-ibadah/edit', 'edit');
    Route::get('/rumah-ibadah/show', 'show');

});

Route::controller(TempatWisataController::class)->group(function () {
    Route::get('/wisata', 'index');
    Route::get('/wisata/create', 'create');
    Route::get('/wisata/edit', 'edit');
    Route::get('/wisata/show', 'show');
});

Route::controller(SekolahController::class)->group(function () {
    Route::get('/sekolah', 'index');
    Route::get('/sekolah/create', 'create');
    Route::get('/sekolah/edit', 'edit');
    Route::get('/sekolah/show', 'show');
});

Route::controller(PasarController::class)->group(function () {
    Route::get('/dataPasar/data',[DataController::class,'dataPasar'])->name('data-pasar');
    Route::resource('pasar',(PasarController::class));
    // Route::get('pasar','App\Http\Controllers\admin\PasarController');

});

//desa
Route::controller(ArtikelController::class)->group(function () {
    Route::get('/artikel', 'index');
    Route::get('/artikel/create', 'create');
    Route::get('/artikel/edit', 'edit');
    Route::get('/artikel/show', 'show');
});

Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'index');
    Route::get('/profile/create', 'create');
    Route::get('/profile/edit', 'edit');
    Route::get('/profile/show', 'show');
});

Route::controller(PemerintahanController::class)->group(function () {
    Route::get('/pemerintahan', 'index');
    Route::get('/pemerintahan/create', 'create');
    Route::get('/pemerintahan/edit', 'edit');
    Route::get('/pemerintahan/show', 'show');
});

Route::controller(DataDesaController::class)->group(function () {
    Route::get('/data', 'index');
    Route::get('/data/create', 'create');
    Route::get('/data/edit', 'edit');
    Route::get('/data/show', 'show');
});
