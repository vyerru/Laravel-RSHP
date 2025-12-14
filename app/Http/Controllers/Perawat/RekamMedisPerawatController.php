<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\TemuDokter;
use App\Models\RekamMedis;

class RekamMedisPerawatController extends Controller
{
    public function index()
    {
        // Kita load relasi 'rekamMedis' agar data lama (jika ada) bisa ditampilkan di Modal saat Edit
        $antrian = TemuDokter::with(['pet.pemilik.user', 'pet.rasHewan', 'rekamMedis'])
            ->whereDate('waktu_daftar', Carbon::today())
            ->where('status', '0') // Status Menunggu
            ->orderBy('no_urut', 'asc')
            ->get();

        return view('Perawat.Pemeriksaan.index', compact('antrian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idreservasi_dokter' => 'required',
            'anamnesa' => 'required',
            'temuan_klinis' => 'required',
        ]);

        // Simpan atau Update data
        RekamMedis::updateOrCreate(
            ['idreservasi_dokter' => $request->idreservasi_dokter],
            [
                'anamnesa' => $request->anamnesa,
                'temuan_klinis' => $request->temuan_klinis,
                // Beri nilai default 0 atau null untuk dokter_pemeriksa agar tidak error
                // Nanti akan diupdate oleh Dokter saat pemeriksaan
                'dokter_pemeriksa' => $request->dokter_pemeriksa_dummy ?? 0
            ]
        );

        return redirect()->back()->with('success', 'Data pemeriksaan awal berhasil disimpan.');
    }

    // Method show (Detail) tetap sama...
    public function show($id)
    {
        $reservasi = TemuDokter::with([
            'pet',
            'rekamMedis' => function ($q) {
                $q->latest(); // Ambil yang terbaru saja jika ada banyak
            }
        ])->findOrFail($id);
        return view('Perawat.Pemeriksaan.show', compact('reservasi'));
    }
}