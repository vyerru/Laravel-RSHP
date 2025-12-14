<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Pemilik;
use App\Models\RasHewan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    public function index() {
        // Ambil data Pet dengan relasinya (Eager Loading)
        $pets = Pet::with(['pemilik.user', 'rasHewan.jenisHewan'])->get();
        
        // Data untuk Dropdown di Modal
        // Ambil pemilik yang punya user aktif
        $pemilik = Pemilik::with('user')->get(); 
        $rasHewan = RasHewan::with('jenisHewan')->get();

        return view('Admin.Pet.index', compact('pets', 'pemilik', 'rasHewan'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'warna_tanda' => 'required|string|max:45',
            'jenis_kelamin' => 'required|in:j,b', // j=Jantan, b=Betina
            'idpemilik' => 'required|exists:pemilik,idpemilik',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
        ]);

        Pet::create([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'warna_tanda' => $request->warna_tanda,
            'jenis_kelamin' => $request->jenis_kelamin,
            'idpemilik' => $request->idpemilik,
            'idras_hewan' => $request->idras_hewan,
        ]);

        return redirect()->route('Admin.Pet.index')
            ->with('success', 'Data Hewan berhasil ditambahkan');
    }

    public function update(Request $request, $id) {
        $pet = Pet::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'warna_tanda' => 'required|string|max:45',
            'jenis_kelamin' => 'required|in:j,b',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
        ]);

        $pet->update([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'warna_tanda' => $request->warna_tanda,
            'jenis_kelamin' => $request->jenis_kelamin,
            'idpemilik' => $request->idpemilik,
            'idras_hewan' => $request->idras_hewan,
        ]);

        return redirect()->route('Admin.Pet.index')
            ->with('success', 'Data Hewan berhasil diperbarui');
    }

    public function destroy($id) {
        $pet = Pet::findOrFail($id);
        
        // Catat siapa yang menghapus
        $pet->deleted_by = Auth::id();
        $pet->save();
        
        // Soft Delete
        $pet->delete();

        return redirect()->route('Admin.Pet.index')
            ->with('success', 'Data Hewan berhasil dihapus');
    }
}