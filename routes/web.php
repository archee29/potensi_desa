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

// Route::controller(LokasiController::class)->group(function () {
//     Route::get('/lokasi','LokasiController@index')->name('lokasi.index');
//     Route::get('/lokasi/create','admin\LokasiController@create')->name('lokasi.create');
//     Route::get('/lokasi/edit','admin\LokasiController@edit')->name('lokasi.edit');
//     Route::get('/lokasi/show','admin\LokasiController@show')->name('lokasi.show');
// });



//lokasi
// Route::resource('lokasi',LokasiController::class );

// //potensi
// Route::resource('rumah-ibadah', RumahIbadahController::class);
// Route::resource('wisata', TempatWisata::class);
// Route::resource('sekolah', SekolahController::class);
// Route::resource('pasar', PasarController::class);

//pasar
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
    Route::get('/pasar', 'index');
    Route::get('/pasar/create', 'create');
    Route::get('/pasar/edit', 'edit');
    Route::get('/pasar/show', 'show');
});

//desa
// Route::resource('artikel', ArtikelController::class);
// Route::resource('profile', ProfileController::class);
// Route::resource('pemerintahan', PemerintahanController::class);
// Route::resource('data', DataDesaController::class);

// //lokasi
// Route::resource('lokasi', [App\Http\Controllers\admin\LokasiController::class, 'index'])->name('lokasi');

// //potensi
// Route::resource('rumah-ibadah', [App\Http\Controllers\admin\RumahIbadahController::class, 'index'])->name('rumah-ibadah');
// Route::resource('wisata', [App\Http\Controllers\admin\TempatWisataController::class, 'index'])->name('wisata');
// Route::resource('sekolah', [App\Http\Controllers\admin\SekolahController::class, 'index'])->name('sekolah');
// Route::resource('pasar', [App\Http\Controllers\admin\PasarController::class, 'index'])->name('pasar');

//lokasi
Route::resource('data', DataController::class);

Route::controller(LokasiController::class)->group(function () {
    Route::resource('lokasi', LokasiController::class);
    Route::get('lokasi/data', [DataController::class, 'lokasi'])->name('data-lokasi');
    Route::get('/lokasi', 'index');
    Route::get('/lokasi/create', 'create');
    Route::get('/lokasi/edit', 'edit');
    Route::get('/lokasi/show', 'show');
    Route::resource('lokasi', (LokasiController::class));
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



// //desa
// Route::resource('artikel', [App\Http\Controllers\admin\ArtikelController::class, 'index'])->name('artikel');
// Route::resource('profile', [App\Http\Controllers\admin\ProfileController::class, 'index'])->name('profile');
// Route::resource('pemerintahan', [App\Http\Controllers\admin\PemerintahanController::class, 'index'])->name('pemerintahan');
// Route::resource('data', [App\Http\Controllers\admin\DataDesaController::class, 'index'])->name('data');
