<?php

use App\Http\Controllers\Admin\JenisHewanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\KategoriKlinisController;
use App\Http\Controllers\Admin\KodeTindakanController;
use App\Http\Controllers\Admin\PemilikController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\RasHewanController;
use App\Http\Controllers\Admin\RekamMedisController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoleUserController;
use App\Http\Controllers\Admin\TemuDokterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Middleware\isAdministrator;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\isResepsionis;

Auth::routes();

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [SiteController::class, 'index'])->name('index');

Route::get('/layanan', [SiteController::class, 'Layanan']);

Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('Site.cek-koneksi');


// Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'isAdministrator'])->group(function () {
    Route::get('/admin/data-master', [DashboardAdminController::class, 'dataMaster'])->name('admin/data-master');
    Route::get('/admin/dashboard', [DashboardAdminController::class, 'index'])->name('Admin.dashboard');
    Route::prefix('admin/jenis-hewan')->name('Admin.jenis-hewan.')->group(function () {
        Route::get('/', [JenisHewanController::class, 'index'])->name('index');
        Route::post('/', [JenisHewanController::class, 'store'])->name('store');
        Route::put('/{id}', [JenisHewanController::class, 'update'])->name('update');
        Route::delete('/{id}', [JenisHewanController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('admin/pemilik')->name('Admin.Pemilik.')->group(function () {
        Route::get('/', [PemilikController::class, 'index'])->name('index');
        Route::post('/', [PemilikController::class, 'store'])->name('store');
        Route::put('/{id}', [PemilikController::class, 'update'])->name('update');
        Route::delete('/{id}', [PemilikController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('admin/role-user')->name('Admin.RoleUser.')->group(function () {
        Route::get('/', [RoleUserController::class, 'index'])->name('index');
        Route::post('/', [RoleUserController::class, 'store'])->name('store');
        Route::put('/{id}', [RoleUserController::class, 'update'])->name('update'); // ID yang dikirim adalah ID RoleUser
        Route::delete('/{id}', [RoleUserController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('admin/role')->name('Admin.Role.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::put('/{id}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{id}', [RoleController::class, 'destroy'])->name('destroy');
    });
    Route::get('/admin/pet', [PetController::class, 'index'])->name('Admin.Pet.index');
    Route::prefix('admin/kategori')->name('Admin.Kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::put('/{id}', [KategoriController::class, 'update'])->name('update');
        Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('admin/kategori-klinis')->name('Admin.KategoriKlinis.')->group(function () {
        Route::get('/', [KategoriKlinisController::class, 'index'])->name('index');
        Route::post('/', [KategoriKlinisController::class, 'store'])->name('store');
        Route::put('/{id}', [KategoriKlinisController::class, 'update'])->name('update');
        Route::delete('/{id}', [KategoriKlinisController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('admin/kode-tindakan')->name('Admin.KodeTindakan.')->group(function () {
        Route::get('/', [KodeTindakanController::class, 'index'])->name('index');
        Route::post('/', [KodeTindakanController::class, 'store'])->name('store');
        Route::put('/{id}', [KodeTindakanController::class, 'update'])->name('update');
        Route::delete('/{id}', [KodeTindakanController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('admin/ras-hewan')->name('Admin.RasHewan.')->group(function () {
        Route::get('/', [RasHewanController::class, 'index'])->name('index');
        Route::post('/', [RasHewanController::class, 'store'])->name('store');
        Route::put('/{id}', [RasHewanController::class, 'update'])->name('update');
        Route::delete('/{id}', [RasHewanController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('admin/pet')->name('Admin.Pet.')->group(function () {
        Route::get('/', [PetController::class, 'index'])->name('index');
        Route::post('/', [PetController::class, 'store'])->name('store');
        Route::put('/{id}', [PetController::class, 'update'])->name('update');
        Route::delete('/{id}', [PetController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('admin/reservasi')->name('Admin.TemuDokter.')->group(function () {
        Route::get('/', [TemuDokterController::class, 'index'])->name('index');
        Route::post('/', [TemuDokterController::class, 'store'])->name('store');
        Route::put('/{id}', [TemuDokterController::class, 'update'])->name('update');
        Route::delete('/{id}', [TemuDokterController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('admin/rekam-medis')->name('Admin.RekamMedis.')->group(function () {
        Route::get('/', [RekamMedisController::class, 'index'])->name('index');
        Route::post('/', [RekamMedisController::class, 'store'])->name('store');
        Route::put('/{id}', [RekamMedisController::class, 'update'])->name('update');
        Route::delete('/{id}', [RekamMedisController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware(['auth', 'isResepsionis'])->group(function () {
    Route::get('/resepsionis/dashboard', [App\Http\Controllers\Resepsionis\DashboardResepsionisController::class, 'index'])->name('resepsionis.dashboard');
    Route::get('/resepsionis/registrasi-pemilik', [App\Http\Controllers\Resepsionis\RegistrasiPemilikController::class, 'index'])->name('resepsionis.registrasi.pemilik');
    Route::get('/resepsionis/registrasi-pet', [App\Http\Controllers\Resepsionis\RegistrasiPetController::class, 'index'])->name('resepsionis.registrasi.pet');
    Route::get('/resepsionis/temu-dokter', [App\Http\Controllers\Resepsionis\TemuDokterController::class, 'index'])->name('resepsionis.temu-dokter.index');
});

Route::middleware(['auth', 'dokter'])->group(function () {

    // 1. Dashboard Dokter
    Route::get('/dokter/dashboard', [App\Http\Controllers\Dokter\DashboardDokterController::class, 'index'])->name('Dokter.Dashboard.index');

    // 2. Data Pasien (Read Only)
    Route::prefix('dokter/pasien')->name('Dokter.Pasien.')->group(function () {
        Route::get('/', [App\Http\Controllers\Dokter\PasienDokterController::class, 'index'])->name('index');
        Route::get('/{id}', [App\Http\Controllers\Dokter\PasienDokterController::class, 'show'])->name('show');
    });

    // 3. Riwayat Pemeriksaan Saya (List History)
    Route::prefix('dokter/rekam-medis')->name('Dokter.RekamMedis.')->group(function () {
        Route::get('/', [App\Http\Controllers\Dokter\RekamMedisDokterController::class, 'index'])->name('index');
    });

    // 4. Proses Pemeriksaan (Input Diagnosa & Tindakan)
    Route::prefix('dokter/pemeriksaan')->name('Dokter.Pemeriksaan.')->group(function () {
        // Halaman Form Periksa
        Route::get('/{id_reservasi}', [App\Http\Controllers\Dokter\RekamMedisDokterController::class, 'edit'])->name('edit');

        // Simpan Diagnosa Utama (Update)
        Route::put('/update-diagnosa/{id}', [App\Http\Controllers\Dokter\RekamMedisDokterController::class, 'updateDiagnosa'])->name('updateDiagnosa');

        // CRUD Detail Tindakan (Child)
        Route::post('/detail/store', [App\Http\Controllers\Dokter\RekamMedisDokterController::class, 'storeDetail'])->name('storeDetail');
        Route::delete('/detail/{id}', [App\Http\Controllers\Dokter\RekamMedisDokterController::class, 'destroyDetail'])->name('destroyDetail');
    });

    // Placeholder Profil (Nanti dibuat terpisah)
    Route::prefix('dokter/profil')->name('Dokter.Profil.')->group(function () {
        Route::get('/', [App\Http\Controllers\Dokter\ProfilDokterController::class, 'index'])->name('index');
    });
});

Route::middleware(['auth', 'pemilik'])->group(function () {
    Route::get('/pemilik/dashboard', [App\Http\Controllers\Pemilik\DashboardPemilikController::class, 'index'])->name('Pemilik.Dashboard.index');
});

Route::middleware(['auth', 'perawat'])->group(function () {
    
    // 1. Dashboard
    Route::get('/perawat/dashboard', [App\Http\Controllers\Perawat\DashboardPerawatController::class, 'index'])->name('Perawat.Dashboard.index');

    // 2. Data Pasien (Read Only)
    Route::prefix('perawat/pasien')->name('Perawat.Pasien.')->group(function () {
        Route::get('/', [App\Http\Controllers\Perawat\PasienPerawatController::class, 'index'])->name('index');
    });

    // 3. Pemeriksaan Awal (Triage) - Input Anamnesa & Vital
    Route::prefix('perawat/pemeriksaan')->name('Perawat.Pemeriksaan.')->group(function () {
        Route::get('/', [App\Http\Controllers\Perawat\RekamMedisPerawatController::class, 'index'])->name('index'); // List Antrian
        Route::get('/create/{id_reservasi}', [App\Http\Controllers\Perawat\RekamMedisPerawatController::class, 'create'])->name('create'); // Form Input
        Route::post('/store', [App\Http\Controllers\Perawat\RekamMedisPerawatController::class, 'store'])->name('store'); // Simpan Data
        Route::get('/show/{id}', [App\Http\Controllers\Perawat\RekamMedisPerawatController::class, 'show'])->name('show'); // Lihat Detail
    });

    // 4. Profil
    Route::get('/perawat/profil', [App\Http\Controllers\Perawat\ProfilPerawatController::class, 'index'])->name('Perawat.Profil.index');
});