<?php

use Illuminate\Support\Facades\Route;

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


//dashboard
Route::get('/home', [App\Http\Controllers\admin\HomeController::class, 'index'])->name('home');

//lokasi
Route::get('/lokasi', [App\Http\Controllers\admin\LokasiController::class, 'index'])->name('lokasi');

//potensi
Route::get('/rumah-ibadah', [App\Http\Controllers\admin\RumahIbadahController::class, 'index'])->name('rumah-ibadah');
Route::get('/wisata', [App\Http\Controllers\admin\TempatWisataController::class, 'index'])->name('wisata');
Route::get('/sekolah', [App\Http\Controllers\admin\SekolahController::class, 'index'])->name('sekolah');
Route::get('/pasar', [App\Http\Controllers\admin\PasarController::class, 'index'])->name('pasar');

//desa
Route::get('/artikel', [App\Http\Controllers\admin\ArtikelController::class, 'index'])->name('artikel');
Route::get('/profile', [App\Http\Controllers\admin\ProfileController::class, 'index'])->name('profile');
Route::get('/pemerintahan', [App\Http\Controllers\admin\PemerintahanController::class, 'index'])->name('pemerintahan');
Route::get('/data', [App\Http\Controllers\admin\DataController::class, 'index'])->name('data');
