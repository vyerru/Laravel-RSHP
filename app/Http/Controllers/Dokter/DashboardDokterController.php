<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\TemuDokter;
use App\Models\RekamMedis;
use App\Models\RoleUser;

class DashboardDokterController extends Controller
{
    public function index()
    {
        // 1. Ambil ID RoleUser untuk Dokter yang sedang login
        // Kita cari data di tabel role_user dimana iduser = Auth::id() DAN idrole = 2 (Dokter)
        $dokter = RoleUser::where('iduser', Auth::id())
                    ->where('idrole', 2) // Asumsi ID Role 2 = Dokter
                    ->first();

        // Cek validasi (Jaga-jaga jika user login tapi datanya ga ada di role_user)
        if (!$dokter) {
            abort(403, 'Data profil dokter tidak ditemukan.');
        }

        $hariIni = Carbon::today();

        // 2. Hitung Statistik (Real Data)
        $stats = [
            // Jumlah pasien yang mendaftar ke dokter ini HARI INI
            'pasien_hari_ini' => TemuDokter::where('idrole_user', $dokter->idrole_user)
                                    ->whereDate('waktu_daftar', $hariIni)
                                    ->count(),

            // Total rekam medis yang pernah dibuat dokter ini (sepanjang waktu)
            'total_rekam_medis' => RekamMedis::where('dokter_pemeriksa', $dokter->idrole_user)
                                    ->count(),

            // Jadwal Aktif: Pasien hari ini yang statusnya BELUM Selesai (0=Menunggu, 1=Diperiksa)
            'jadwal_aktif' => TemuDokter::where('idrole_user', $dokter->idrole_user)
                                    ->whereDate('waktu_daftar', $hariIni)
                                    ->whereIn('status', ['0', '1'])
                                    ->count()
        ];

        // 3. Ambil Daftar Antrian Pasien Hari Ini
        $pasienHariIni = TemuDokter::with(['pet.pemilik.user', 'pet.rasHewan']) // Load relasi
                            ->where('idrole_user', $dokter->idrole_user)
                            ->whereDate('waktu_daftar', $hariIni)
                            ->orderBy('no_urut', 'asc') // Urutkan berdasarkan nomor antrian/jam
                            ->get();

        return view('Dokter.dashboard', compact('stats', 'pasienHariIni'));
    }
}