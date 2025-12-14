<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet;

class PasienDokterController extends Controller
{
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
            ->orderBy('nama', 'asc')->paginate(10);

        return view('Dokter.Pasien.index', compact('pets'));
    }

    public function show($id)
    {
        $pet = Pet::with([
            'pemilik.user', 
            'rasHewan.jenisHewan',
            'rekamMedis' => function($q) { $q->orderBy('created_at', 'desc'); },
            'rekamMedis.dokter.user'
        ])->findOrFail($id);

        return view('Dokter.Pasien.show', compact('pet'));
    }
}