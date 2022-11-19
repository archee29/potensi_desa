<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\MapKaLimas;
// use Illminate\Support\Facades\Auth;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\MapController;
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
use App\Models\Artikel;
use Database\Seeders\ArtikelSeeder;
use Illuminate\Routing\RouteGroup;

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

Route::get('/peta',[App\Http\Controllers\admin\MapController::class,'index'])->name('peta.index');
Route::get('/peta/showPasar/{slug}',[App\Http\Controllers\admin\MapController::class, 'showPasar'])->name('peta.showPasar');
Route::get('/peta/showSekolah/{slug}',[App\Http\Controllers\admin\MapController::class, 'showSekolah'])->name('peta.showSekolah');
Route::get('/peta/showRumahIbadah/{slug}',[App\Http\Controllers\admin\MapController::class, 'showRumahIbadah'])->name('peta.showRumahIbadah');
Route::get('/peta/wisata/{slug}',[App\Http\Controllers\admin\MapController::class, 'showWisata'])->name('peta.showWisata');

// Route::resource('/peta', MapController::class);

Auth::routes();

// aa
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/map',[App\Http\Controllers\MapController::class,'index'])->name('map.index');
// Route::get('/map', [App\Http\livewire\MapKalimas::class, 'render'])->name('map-kalimas');
//dashboard
Route::resource('home', HomeController::class);



//lokasi
Route::controller(LokasiController::class)->group(function () {
    Route::get('/dataLokasi/data',[DataController::class,'dataLokasi'])->name('data-lokasi');
    Route::resource('lokasi',(LokasiController::class));
});


// Potensi

Route::controller(RumahIbadahController::class)->group(function () {
    Route::get('/dataRumahIbadah/data',[DataController::class,'dataRumahIbadah'])->name('data-RumahIbadah');
    Route::resource('rumah-ibadah',(RumahIbadahController::class));

});

Route::controller(TempatWisataController::class)->group(function () {
    Route::get('/dataWisata/data',[DataController::class,'dataWisata'])->name('data-wisata');
    Route::resource('wisata',(TempatWisataController::class));
    // Route::get('/wisata', 'index')->name('wisata.index');
    // Route::get('/wisata/create','create')->name('wisata.create');
    // Route::post('/wisata','store')->name('wisata.store');
    // Route::get('/wisata/detail/{id}', 'show')->name('wisata.show');
    // Route::get('/wisata/edit/{id}', 'edit')->name('wisata.edit');
    // Route::put('/wisata/edit/{id}','update')->name('wisata.update');
    // Route::get('/wisata/delete/{id}', 'destroy')->name('wisata.destroy');

});

Route::controller(SekolahController::class)->group(function () {
    Route::get('/dataSekolah/data',[DataController::class,'dataSekolah'])->name('data-sekolah');
    Route::resource('sekolah',(SekolahController::class));
});

Route::controller(PasarController::class)->group(function () {
    Route::get('/dataPasar/data',[DataController::class,'dataPasar'])->name('data-pasar');
    Route::resource('pasar',(PasarController::class));
    // Route::get('pasar','App\Http\Controllers\admin\PasarController');

});

//desa artikel
Route::controller(ArtikelController::class)->group(function () {
//     Route::get('artikel', 'index');
//     Route::get('artikel/create', 'create');
//     Route::get('artikel/edit', 'edit');
//     Route::get('artikel/show', 'show');

    Route::get('/artikel', 'index');
    Route::get('/artikel/create','create')->name('artikel.create');
    Route::post('/artikel','store')->name('artikel.store');
    Route::get('/artikel/detail/{id}', 'show')->name('artikel.show');
    Route::get('/artikel/edit/{id}', 'edit')->name('artikel.edit');
    Route::put('/artikel/edit/{id}','update')->name('artikel.update');
    Route::get('/artikel/delete/{id}', 'destroy')->name('artikel.destroy');

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
