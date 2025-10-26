<?php

use App\Http\Controllers\Admin\JenisHewanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\KategoriKlinisController;
use App\Http\Controllers\Admin\KodeTindakanController;
use App\Http\Controllers\Admin\PemilikController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\RasHewanController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoleUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\SiteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [SiteController::class, 'index'])->name('index');

Route::get('/layanan', [SiteController::class, 'Layanan']);

Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('Site.cek-koneksi');

Route::get('/admin/jenis-hewan', [JenisHewanController::class, 'index'])->name('Admin.jenis-hewan.index');
Route::get('/admin/pemilik', [PemilikController::class, 'index'])->name('Admin.Pemilik.index');

Route::get('/admin/role-user', [RoleUserController::class, 'index'])->name('Admin.RoleUser.index');
Route::get('/admin/role', [RoleController::class, 'index'])->name('Admin.Pemilik.index');
Route::get('/admin/pet', [PetController::class, 'index'])->name('Admin.Pet.index');
Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('Admin.Kategori.index');
Route::get('admin/kategori-klinis', [KategoriKlinisController::class, 'index'])->name('Admin.KategoriKlinis.index');
Route::get('admin/kode-tindakan', [KodeTindakanController::class, 'index'])->name('Admin.KodeTindakan.index');
Route::get('admin/ras-hewan', [RasHewanController::class, 'index'])->name('Admin.RasHewan.index');