<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemilik;

class ProfilSayaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data detail pemilik
        // firstOrCreate digunakan agar jika data kosong, tidak error (dibuatkan default)
        $pemilik = Pemilik::firstOrCreate(
            ['iduser' => $user->iduser],
            ['no_wa' => '-', 'alamat' => '-']
        );

        return view('Pemilik.Profil.index', compact('user', 'pemilik'));
    }
}