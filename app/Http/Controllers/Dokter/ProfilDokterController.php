<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Dokter;
use App\Models\RekamMedis;
use App\Models\RoleUser;

class ProfilDokterController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data detail dokter
        // Jika belum ada di tabel dokter, buat data dummy sementara agar tidak error
        $dokter = Dokter::firstOrCreate(
            ['id_user' => $user->iduser],
            [
                'alamat' => '-', 
                'no_hp' => '-', 
                'bidang_dokter' => 'Dokter Umum', 
                'jenis_kelamin' => 'L'
            ]
        );

        // Ambil ID RoleUser untuk menghitung statistik pasien
        $dokterId = RoleUser::where('iduser', $user->iduser)->where('idrole', 2)->value('idrole_user');
        
        // Hitung total pasien yang pernah diperiksa
        $totalPasien = RekamMedis::where('dokter_pemeriksa', $dokterId)->count();

        // Hitung pasien hari ini (Opsional, pemanis tampilan)
        $pasienHariIni = RekamMedis::where('dokter_pemeriksa', $dokterId)
                        ->whereDate('created_at', now())
                        ->count();

        return view('Dokter.Profil.index', compact('user', 'dokter', 'totalPasien', 'pasienHariIni'));
    }
}