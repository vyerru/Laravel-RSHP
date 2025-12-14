<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemilik;
use App\Models\Pet;

class HewanSayaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pemilik = Pemilik::where('iduser', $user->iduser)->firstOrFail();
        
        $pets = Pet::with(['rasHewan.jenisHewan'])
            ->where('idpemilik', $pemilik->idpemilik)
            ->get();

        return view('Pemilik.Hewan.index', compact('pets'));
    }

    // Menampilkan History Pemeriksaan satu hewan
    public function riwayat($id)
    {
        // Pastikan hewan ini benar milik user yang login (Security Check)
        $user = Auth::user();
        $pemilik = Pemilik::where('iduser', $user->iduser)->first();

        $pet = Pet::where('idpet', $id)
            ->where('idpemilik', $pemilik->idpemilik)
            ->with(['rekamMedis.dokter.user', 'rekamMedis.detailTindakan.tindakan'])
            ->firstOrFail();

        return view('Pemilik.Hewan.riwayat', compact('pet'));
    }
}