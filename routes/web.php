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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/lokasi', [App\Http\Controllers\HomeController::class, 'lokasi'])->name('lokasi');
Route::get('/artikel', [App\Http\Controllers\HomeController::class, 'artikel'])->name('artikel');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
Route::get('/pemerintahan', [App\Http\Controllers\HomeController::class, 'pemerintahan'])->name('pemerintahan');
Route::get('/data', [App\Http\Controllers\HomeController::class, 'data'])->name('data');
