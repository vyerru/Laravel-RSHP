<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet;

class PasienDokterController extends Controller
{
    /**
     * Menampilkan daftar semua pasien (Pet)
     * Dokter bisa mencari berdasarkan nama hewan atau nama pemilik.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pets = Pet::with(['pemilik.user', 'rasHewan.jenisHewan'])
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                             ->orWhereHas('pemilik.user', function ($q) use ($search) {
                                 $q->where('nama', 'like', "%{$search}%");
                             });
            })
            ->orderBy('nama', 'asc')
            ->paginate(10); // Gunakan pagination agar halaman tidak berat

        return view('Dokter.Pasien.index', compact('pets'));
    }

    /**
     * Menampilkan Detail Pasien & Riwayat Rekam Medis
     */
    public function show($id)
    {
        // Ambil data Pet beserta:
        // 1. Pemilik & Usernya
        // 2. Ras & Jenis Hewan
        // 3. Rekam Medis (History) -> beserta Dokter yang memeriksa
        $pet = Pet::with([
            'pemilik.user', 
            'rasHewan.jenisHewan',
            'rekamMedis' => function($q) {
                $q->orderBy('created_at', 'desc'); // Urutkan history dari yang terbaru
            },
            'rekamMedis.dokter.user' // Ambil nama dokter di history
        ])->findOrFail($id);

        return view('Dokter.Pasien.show', compact('pet'));
    }
}