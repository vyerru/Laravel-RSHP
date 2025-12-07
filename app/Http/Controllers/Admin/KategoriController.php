<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index() {
        $kategori = Kategori::all();
        return view('Admin.Kategori.index', compact('kategori'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('Admin.Kategori.index')
            ->with('success', 'Data Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id) {
        $kategori = Kategori::findOrFail($id);
        
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,'.$kategori->idkategori.',idkategori',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('Admin.Kategori.index')
            ->with('success', 'Data Kategori berhasil diperbarui');
    }

    public function destroy($id) {
        $kategori = Kategori::findOrFail($id);
        
        // Opsional: Cek apakah kategori sedang digunakan di Kode Tindakan?
        // if($kategori->kodeTindakan()->exists()) {
        //    return back()->withErrors(['Kategori ini masih memiliki data Kode Tindakan.']);
        // }

        // Catat siapa yang menghapus
        $kategori->deleted_by = Auth::id();
        $kategori->save();
        
        // Soft Delete
        $kategori->delete();

        return redirect()->route('Admin.Kategori.index')
            ->with('success', 'Data Kategori berhasil dihapus');
    }
}