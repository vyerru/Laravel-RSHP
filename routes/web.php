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
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Middleware\isAdministrator;
use App\Http\Controllers\Auth\LoginController;

Auth::routes();

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [SiteController::class, 'index'])->name('index');

Route::get('/layanan', [SiteController::class, 'Layanan']);

Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('Site.cek-koneksi');


// Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'isAdministrator'])->group(function (){
    Route::get('/admin/data-master', [DashboardAdminController::class, 'dataMaster'])->name('admin/data-master');
    Route::get('/admin/dashboard', [DashboardAdminController::class, 'index'])->name('Admin.dashboard');
    Route::get('/admin/jenis-hewan', [JenisHewanController::class, 'index'])->name('Admin.jenis-hewan.index');
    Route::get('/admin/pemilik', [PemilikController::class, 'index'])->name('Admin.Pemilik.index');
    Route::get('/admin/role-user', [RoleUserController::class, 'index'])->name('Admin.RoleUser.index');
    Route::get('/admin/role', [RoleController::class, 'index'])->name('Admin.Role.index');
    Route::get('/admin/pet', [PetController::class, 'index'])->name('Admin.Pet.index');
    Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('Admin.Kategori.index');
    Route::get('admin/kategori-klinis', [KategoriKlinisController::class, 'index'])->name('Admin.KategoriKlinis.index');
    Route::get('admin/kode-tindakan', [KodeTindakanController::class, 'index'])->name('Admin.KodeTindakan.index');
    Route::get('admin/ras-hewan', [RasHewanController::class, 'index'])->name('Admin.RasHewan.index');
});

Route::middleware(['auth', 'isResepsionis'])->group(function (){
    Route::get('/resepsionis/dashboard', [App\Http\Controllers\Resepsionis\DashboardResepsionisController::class, 'index'])->name('Resepsionis.Dashboard.index');
});

Route::middleware(['auth','dokter'])->group(function (){
    Route::get('/dokter/dashboard', [App\Http\Controllers\Dokter\DashboardDokterController::class, 'index'])->name('Dokter.Dashboard.index');
});

Route::middleware(['auth', 'pemilik'])->group(function (){
    Route::get('/pemilik/dashboard', [App\Http\Controllers\Pemilik\DashboardPemilikController::class, 'index'])->name('Pemilik.Dashboard.index');
});

Route::middleware(['auth','perawat'])->group(function (){
    Route::get('/perawat/dashboard', [App\Http\Controllers\Perawat\DashboardPerawatController::class, 'index'])->name('Perawat.Dashboard.index');
});