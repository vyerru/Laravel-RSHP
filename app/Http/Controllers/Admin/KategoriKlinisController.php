<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKlinis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriKlinisController extends Controller
{
    public function index() {
        $kategoriKlinis = KategoriKlinis::all();
        return view('Admin.KategoriKlinis.index', compact('kategoriKlinis'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_kategori_klinis' => 'required|string|max:50|unique:kategori_klinis,nama_kategori_klinis',
        ]);

        KategoriKlinis::create([
            'nama_kategori_klinis' => $request->nama_kategori_klinis
        ]);

        return redirect()->route('Admin.KategoriKlinis.index')
            ->with('success', 'Data Kategori Klinis berhasil ditambahkan');
    }

    public function update(Request $request, $id) {
        $kategori = KategoriKlinis::findOrFail($id);
        
        $request->validate([
            'nama_kategori_klinis' => 'required|string|max:50|unique:kategori_klinis,nama_kategori_klinis,'.$kategori->idkategori_klinis.',idkategori_klinis',
        ]);

        $kategori->update([
            'nama_kategori_klinis' => $request->nama_kategori_klinis
        ]);

        return redirect()->route('Admin.KategoriKlinis.index')
            ->with('success', 'Data Kategori Klinis berhasil diperbarui');
    }

    public function destroy($id) {
        $kategori = KategoriKlinis::findOrFail($id);
        
        // Catat siapa yang menghapus
        $kategori->deleted_by = Auth::id();
        $kategori->save();
        
        // Soft Delete
        $kategori->delete();

        return redirect()->route('Admin.KategoriKlinis.index')
            ->with('success', 'Data Kategori Klinis berhasil dihapus');
    }
}