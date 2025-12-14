<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\TemuDokter;
use App\Models\Pet;
use App\Models\Pemilik;

class DashboardResepsionisController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();

        // Statistik Hari Ini
        $stats = [
            'antrian_hari_ini' => TemuDokter::whereDate('waktu_daftar', $hariIni)->count(),
            'pasien_baru' => Pet::count(),
            'total_pemilik' => Pemilik::count(),
        ];

        // Daftar Antrian Hari Ini
        $antrian = TemuDokter::with(['pet.pemilik.user', 'dokter.user'])
            ->whereDate('waktu_daftar', $hariIni)
            ->orderBy('no_urut', 'asc')
            ->get();

        return view('Resepsionis.dashboard', compact('stats', 'antrian'));
    }
}