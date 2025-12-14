<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet;

class PetController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'idpemilik' => 'required|exists:pemilik,idpemilik',
            'nama' => 'required|string|max:100',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',

            // UBAH DI SINI: Validasi sekarang mengecek J atau B
            'jenis_kelamin' => 'required|in:J,B',

            'tanggal_lahir' => 'required|date',
            'warna_tanda' => 'nullable|string',
        ]);

        Pet::create($request->all());

        return redirect()->back()->with('success', 'Data hewan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);
        $pet->update($request->all());
        return redirect()->back()->with('success', 'Data hewan diperbarui.');
    }
}