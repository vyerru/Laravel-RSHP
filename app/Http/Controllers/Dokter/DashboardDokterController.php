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
        $dokter = RoleUser::where('iduser', Auth::id())->where('idrole', 2)->first();
        if (!$dokter) abort(403, 'Data dokter tidak ditemukan.');

        $hariIni = Carbon::today();

        $stats = [
            'pasien_hari_ini' => TemuDokter::where('idrole_user', $dokter->idrole_user)->whereDate('waktu_daftar', $hariIni)->count(),
            'total_rekam_medis' => RekamMedis::where('dokter_pemeriksa', $dokter->idrole_user)->count(),
            'jadwal_aktif' => TemuDokter::where('idrole_user', $dokter->idrole_user)
                                ->whereDate('waktu_daftar', $hariIni)
                                ->whereIn('status', ['0', '1'])->count()
        ];

        $pasienHariIni = TemuDokter::with(['pet.pemilik.user', 'pet.rasHewan'])
                            ->where('idrole_user', $dokter->idrole_user)
                            ->whereDate('waktu_daftar', $hariIni)
                            ->orderBy('no_urut', 'asc')
                            ->get();

        return view('Dokter.dashboard', compact('stats', 'pasienHariIni'));
    }
}