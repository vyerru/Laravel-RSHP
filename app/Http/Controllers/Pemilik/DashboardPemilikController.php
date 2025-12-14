<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Pemilik;
use App\Models\TemuDokter;

class DashboardPemilikController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pemilik = Pemilik::where('iduser', $user->iduser)->first();

        // 1. Cek Apakah ada hewan saya yang sedang antri HARI INI?
        // Kita cari TemuDokter dimana idpet milik user ini, dan tanggal hari ini
        $antrianAktif = TemuDokter::whereHas('pet', function($q) use ($pemilik) {
                $q->where('idpemilik', $pemilik->idpemilik);
            })
            ->whereDate('waktu_daftar', Carbon::today())
            ->where('status', '!=', '2') // Kecuali yang sudah selesai
            ->with(['pet', 'dokter.user'])
            ->first();

        // 2. Data Hewan
        $totalHewan = $pemilik->pets()->count();

        return view('Pemilik.dashboard', compact('antrianAktif', 'totalHewan'));
    }
}