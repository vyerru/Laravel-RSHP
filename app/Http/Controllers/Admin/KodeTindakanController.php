<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodeTindakanTerapi;
use App\Models\Kategori;
use App\Models\KategoriKlinis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KodeTindakanController extends Controller
{
    public function index() {
        // Ambil data Kode Tindakan beserta relasinya (Eager Loading)
        $kodeTindakan = KodeTindakanTerapi::with(['kategori', 'kategoriKlinis'])->get();
        
        // Ambil data untuk dropdown select
        $kategori = Kategori::all();
        $kategoriKlinis = KategoriKlinis::all();

        return view('Admin.KodeTindakan.index', compact('kodeTindakan', 'kategori', 'kategoriKlinis'));
    }

    public function store(Request $request) {
        $request->validate([
            'kode' => 'required|string|max:10|unique:kode_tindakan_terapi,kode',
            'deskripsi_tindakan_terapi' => 'required|string|max:1000',
            'idkategori' => 'required|exists:kategori,idkategori',
            'idkategori_klinis' => 'required|exists:kategori_klinis,idkategori_klinis',
        ]);

        KodeTindakanTerapi::create([
            'kode' => $request->kode,
            'deskripsi_tindakan_terapi' => $request->deskripsi_tindakan_terapi,
            'idkategori' => $request->idkategori,
            'idkategori_klinis' => $request->idkategori_klinis,
        ]);

        return redirect()->route('Admin.KodeTindakan.index')
            ->with('success', 'Data Kode Tindakan berhasil ditambahkan');
    }

    public function update(Request $request, $id) {
        $tindakan = KodeTindakanTerapi::findOrFail($id);
        
        $request->validate([
            // Validasi unik kode kecuali punya diri sendiri
            'kode' => 'required|string|max:10|unique:kode_tindakan_terapi,kode,'.$tindakan->idkode_tindakan_terapi.',idkode_tindakan_terapi',
            'deskripsi_tindakan_terapi' => 'required|string|max:1000',
            'idkategori' => 'required|exists:kategori,idkategori',
            'idkategori_klinis' => 'required|exists:kategori_klinis,idkategori_klinis',
        ]);

        $tindakan->update([
            'kode' => $request->kode,
            'deskripsi_tindakan_terapi' => $request->deskripsi_tindakan_terapi,
            'idkategori' => $request->idkategori,
            'idkategori_klinis' => $request->idkategori_klinis,
        ]);

        return redirect()->route('Admin.KodeTindakan.index')
            ->with('success', 'Data Kode Tindakan berhasil diperbarui');
    }

    public function destroy($id) {
        $tindakan = KodeTindakanTerapi::findOrFail($id);
        
        // Catat siapa yang menghapus
        $tindakan->deleted_by = Auth::id();
        $tindakan->save();
        
        // Soft Delete
        $tindakan->delete();

        return redirect()->route('Admin.KodeTindakan.index')
            ->with('success', 'Data Kode Tindakan berhasil dihapus');
    }
}