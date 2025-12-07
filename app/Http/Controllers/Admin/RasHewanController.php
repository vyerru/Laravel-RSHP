<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RasHewan;
use App\Models\JenisHewan; // Import Model Jenis Hewan
use Illuminate\Support\Facades\Auth;

class RasHewanController extends Controller
{
    public function index() {
        // Mengambil data Ras beserta data Jenis Hewannya (Eager Loading)
        $rasHewan = RasHewan::with('jenisHewan')->get();
        
        // Mengambil data Jenis Hewan untuk Dropdown di Modal Tambah/Edit
        $jenisHewan = JenisHewan::all();
        
        return view('Admin.RasHewan.index', compact('rasHewan', 'jenisHewan'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_ras' => 'required|string|max:100',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan', // Validasi FK
        ]);

        RasHewan::create([
            'nama_ras' => $request->nama_ras,
            'idjenis_hewan' => $request->idjenis_hewan
        ]);

        return redirect()->route('Admin.RasHewan.index')
            ->with('success', 'Data Ras Hewan berhasil ditambahkan');
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nama_ras' => 'required|string|max:100',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
        ]);

        $ras = RasHewan::findOrFail($id);
        $ras->update([
            'nama_ras' => $request->nama_ras,
            'idjenis_hewan' => $request->idjenis_hewan
        ]);

        return redirect()->route('Admin.RasHewan.index')
            ->with('success', 'Data Ras Hewan berhasil diperbarui');
    }

    public function destroy($id) {
        $ras = RasHewan::findOrFail($id);
        
        // Catat siapa yang menghapus
        $ras->deleted_by = Auth::id();
        $ras->save();
        
        // Soft Delete
        $ras->delete();

        return redirect()->route('Admin.RasHewan.index')
            ->with('success', 'Data Ras Hewan berhasil dihapus');
    }
}