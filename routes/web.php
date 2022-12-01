<?php

use App\Http\Controllers\admin\AlbumController;
use App\Models\Artikel;
use App\Http\Livewire\MapKaLimas;
use Illuminate\Routing\RouteGroup;
// use Illminate\Support\Facades\Auth;

// Controller
use Database\Seeders\ArtikelSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\MapController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\admin\DataController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\PasarController;
use App\Http\Controllers\admin\LokasiController;
use App\Http\Controllers\admin\ArtikelController;
use App\Http\Controllers\admin\DataDanaController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\SekolahController;
use App\Http\Controllers\user\DataUserController;
use App\Http\Controllers\admin\DataDesaController;
use App\Http\Controllers\admin\DataPendudukController;
use App\Http\Controllers\admin\MottoDesaController;
// Model
use App\Http\Controllers\admin\WisataDesaController;
use App\Http\Controllers\admin\RumahIbadahController;
use App\Http\Controllers\admin\TentangDesaController;
use App\Http\Controllers\admin\PemerintahanController;
use App\Http\Controllers\admin\VisimisiController;

Route::get('/', function () {
    return view('user.welcome');
});


Route::get('/contoh', function () {
    return view('user.contoh');
});


Route::resource('user', UserController::class);

// Route::get('/',[App\Http\Controllers\user\DataUserController::class,'index'])->name('index');

Route::controller(DataUserController::class)->group(function () {
    Route::get('/detailpotensi/detailSekolah', [App\Http\Controllers\user\DataUserController::class, 'detailDataSekolah'])->name('detail-data-sekolah');
    Route::get('/detailpotensi/detailPasar', [App\Http\Controllers\user\DataUserController::class, 'detailDataPasar'])->name('detail-data-pasar');
    Route::get('/detailpotensi/detailRumahIbadah', [App\Http\Controllers\user\DataUserController::class, 'detailDataRumahIbadah'])->name('detail-data-rumah-ibadah');
    Route::get('/detailpotensi/detailWisata', [App\Http\Controllers\user\DataUserController::class, 'detailDataWisataDesa'])->name('detail-data-wisata');
});


Route::get('/detailPotensi', [App\Http\Controllers\user\UserController::class, 'index'])->name('detailPotensi.index');

Route::controller(MapUserController::class)->group(function () {
    Route::get('/peta', [App\Http\Controllers\user\MapUserController::class, 'index'])->name('peta.index');
    Route::get('/peta/showPasar/{slug}', [App\Http\Controllers\user\MapUserController::class, 'showPasar'])->name('peta.showPasar');
    Route::get('/peta/showSekolah/{slug}', [App\Http\Controllers\user\MapUserController::class, 'showSekolah'])->name('peta.showSekolah');
    Route::get('/peta/showRumahIbadah/{slug}', [App\Http\Controllers\user\MapUserController::class, 'showRumahIbadah'])->name('peta.showRumahIbadah');
    Route::get('/peta/wisata/{slug}', [App\Http\Controllers\user\MapUserController::class, 'showWisata'])->name('peta.showWisata');
});

Auth::routes();



//dashboard
Route::resource('home', HomeController::class);

//lokasi
Route::controller(LokasiController::class)->group(function () {
    Route::get('/dataLokasi/data', [DataController::class, 'dataLokasi'])->name('data-lokasi');
    Route::resource('lokasi', (LokasiController::class));
});


// Potensi

Route::controller(SekolahController::class)->group(function () {
    Route::get('/dataSekolah/data', [DataController::class, 'dataSekolah'])->name('data-sekolah');
    Route::resource('sekolah', (SekolahController::class));
});

Route::controller(PasarController::class)->group(function () {
    Route::get('/dataPasar/data', [DataController::class, 'dataPasar'])->name('data-pasar');
    Route::resource('pasar', (PasarController::class));
});

Route::controller(WisataDesaController::class)->group(function () {
    Route::get('/dataWisataDesa/data', [DataController::class, 'dataWisataDesa'])->name('data-wisata-desa');
    Route::resource('wisata-desa', (WisataDesaController::class));
});

Route::controller(RumahIbadahController::class)->group(function () {
    Route::get('/dataRumahIbadah/data', [DataController::class, 'dataRumahIbadah'])->name('data-RumahIbadah');
    Route::resource('rumah-ibadah', (RumahIbadahController::class));
});


//pemerintahan
Route::controller(PemerintahanController::class)->group(function () {
    Route::get('/dataPemerintahan/data', [DataController::class, 'dataPemerintahan'])->name('data-Pemerintahan');
    Route::resource('pemerintahan', (PemerintahanController::class));
    Route::get('/pemerintahan-desa', 'isiPemerintah');
});

//albumm
Route::controller(AlbumController::class)->group(function () {
    Route::get('/dataAlbum/data', [DataController::class, 'dataAlbum'])->name('data-Album');
    Route::get('/album-desa', 'depanAlbumDesa');
    Route::resource('albumdesa', (AlbumController::class));
});

//Motto Desa
Route::controller(MottoDesaController::class)->group(function () {
    Route::get('/dataMottoDesa/data', [DataController::class, 'dataMottoDesa'])->name('data-MottoDesa');
    Route::get('/motto-desa', 'depanMottoDesa');
    Route::resource('mottodesa', (MottoDesaController::class));
});

//visimisi
Route::controller(VisimisiController::class)->group(function () {
    Route::get('/dataVisimisiDesa/data', [DataController::class, 'dataVisimisiDesa'])->name('data-VisimisiDesa');
    Route::get('/visi-misi', 'depanVisiMisiDesa');
    Route::resource('visimisi', (VisimisiController::class));
});

//tentangDesaaa
Route::controller(TentangDesaController::class)->group(function () {
    Route::get('/dataTentangDesa/data', [DataController::class, 'dataTentangDesa'])->name('data-TentangDesa');
    Route::get('/tentang-desa', 'depanTentangDesa');
    Route::resource('tentangdesa', (TentangDesaController::class));
});




//desa artikel
Route::controller(ArtikelController::class)->group(function () {

    Route::get('/artikel', 'index');
    Route::get('/artikel/create', 'create')->name('artikel.create');
    Route::post('/artikel', 'store')->name('artikel.store');
    Route::get('/artikel/detail/{id}', 'show')->name('artikel.show');
    Route::get('/artikel/edit/{id}', 'edit')->name('artikel.edit');
    Route::put('/artikel/edit/{id}', 'update')->name('artikel.update');
    Route::get('/artikel/delete/{id}', 'destroy')->name('artikel.destroy');
    Route::get('/berita', 'depanArtikel');
    Route::get('/', 'depanHome');
    Route::get('berita/{berita:title}', 'isiArtikel');
});


//data penduduk
Route::controller(DataPendudukController::class)->group(function () {
    Route::get('/dataPendudukDesa/data', [DataController::class, 'dataPendudukDesa'])->name('data-PendudukDesa');
    Route::get('/data-penduduk', 'depanPenduduk');
    Route::resource('datapenduduk', (DataPendudukController::class));
});
