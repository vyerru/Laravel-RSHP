<?php

use App\Http\Controllers\Admin\JenisHewan;
use App\Http\Controllers\Admin\Pemilik;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\SiteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [SiteController::class, 'index'])->name('index');

Route::get('/layanan', [SiteController::class, 'Layanan']);

Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('Site.cek-koneksi');

Route::get('/admin/jenis-hewan', [JenisHewan::class, 'index'])->name('Admin.jenis-hewan.index');
Route::get('/admin/pemilik', [Pemilik::class, 'index'])->name('Admin.pemilik.index');