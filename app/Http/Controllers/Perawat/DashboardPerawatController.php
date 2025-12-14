<?php
namespace App\Http\Controllers\Perawat;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\TemuDokter;
use App\Models\RekamMedis;

class DashboardPerawatController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();

        // Pasien yang mendaftar hari ini
        $pasienHariIni = TemuDokter::with(['pet.pemilik.user', 'pet.rasHewan'])
                            ->whereDate('waktu_daftar', $hariIni)
                            ->orderBy('status', 'asc') // Menunggu (0) di atas
                            ->get();

        $stats = [
            'total_antrian' => $pasienHariIni->count(),
            'menunggu_dokter' => $pasienHariIni->where('status', '0')->count(),
            'selesai' => $pasienHariIni->where('status', '2')->count(),
        ];

        return view('Perawat.dashboard', compact('pasienHariIni', 'stats'));
    }
}