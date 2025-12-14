<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\TemuDokter;

class TemuDokterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'idrole_user' => 'required|exists:role_user,idrole_user', // ID Dokter
        ]);

        $hariIni = Carbon::today();

        // 1. Cek apakah hewan ini SUDAH terdaftar di hari yang sama & status belum selesai?
        $cekDouble = TemuDokter::where('idpet', $request->idpet)
            ->whereDate('waktu_daftar', $hariIni)
            ->where('status', '!=', '2') // Kecuali yang sudah selesai
            ->first();

        if ($cekDouble) {
            return redirect()->back()->with('error', 'Pasien ini sudah terdaftar dalam antrian hari ini.');
        }

        // 2. Generate Nomor Urut (Per Dokter per Hari)
        $lastQueue = TemuDokter::where('idrole_user', $request->idrole_user)
            ->whereDate('waktu_daftar', $hariIni)
            ->max('no_urut');

        $noUrut = $lastQueue ? $lastQueue + 1 : 1;

        // 3. Simpan
        TemuDokter::create([
            'idpet' => $request->idpet,
            'idrole_user' => $request->idrole_user, // Dokter tujuan
            'no_urut' => $noUrut,
            'waktu_daftar' => now(),
            'status' => '0', // Menunggu
        ]);

        return redirect()->route('Resepsionis.Dashboard.index')
            ->with('success', 'Pendaftaran berhasil! No Urut: ' . $noUrut);
    }
}