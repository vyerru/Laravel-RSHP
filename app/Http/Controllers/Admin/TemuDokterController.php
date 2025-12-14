<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemuDokter;
use App\Models\Pet;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TemuDokterController extends Controller
{
    public function index() {
        // Ambil data reservasi urut dari yang terbaru
        $reservasi = TemuDokter::with(['pet.pemilik.user', 'dokter.user'])
            ->orderBy('waktu_daftar', 'desc')
            ->orderBy('no_urut', 'desc')
            ->get();

        // Ambil data Pasien (Pet)
        $pets = Pet::with('pemilik.user')->get();

        // Ambil data Dokter (RoleUser dengan idrole = 2)
       $dokter = RoleUser::with('user')
            ->where('idrole', 2)
            ->where('status', 1)
            ->whereHas('user') 
            ->get();
        // -------------------------
        return view('Admin.TemuDokter.index', compact('reservasi', 'pets', 'dokter'));
    }

    public function store(Request $request) {
        $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'idrole_user' => 'required|exists:role_user,idrole_user', // ID Dokter
            'waktu_daftar' => 'required|date',
        ]);

        // LOGIKA NOMOR URUT OTOMATIS
        // 1. Ambil tanggal saja dari input (Y-m-d)
        $tanggalDaftar = Carbon::parse($request->waktu_daftar)->format('Y-m-d');
        
        // 2. Hitung jumlah antrian pada tanggal tersebut
        $jumlahAntrian = TemuDokter::whereDate('waktu_daftar', $tanggalDaftar)->count();
        
        // 3. Nomor urut = Jumlah + 1
        $noUrutBaru = $jumlahAntrian + 1;

        TemuDokter::create([
            'no_urut' => $noUrutBaru,
            'waktu_daftar' => $request->waktu_daftar,
            'status' => '0', // Default: Menunggu
            'idpet' => $request->idpet,
            'idrole_user' => $request->idrole_user, // Dokter
        ]);

        return redirect()->route('Admin.TemuDokter.index')
            ->with('success', 'Pendaftaran berhasil. No Urut: ' . $noUrutBaru);
    }

    public function update(Request $request, $id) {
        $reservasi = TemuDokter::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:0,1,2,9',
            'waktu_daftar' => 'required|date',
            'idrole_user' => 'required|exists:role_user,idrole_user',
        ]);

        // Cek apakah tanggal berubah? Jika ya, idealnya generate no urut baru (opsional)
        // Di sini kita update data biasa saja
        $reservasi->update([
            'status' => $request->status,
            'waktu_daftar' => $request->waktu_daftar,
            'idrole_user' => $request->idrole_user,
        ]);

        return redirect()->route('Admin.TemuDokter.index')
            ->with('success', 'Data reservasi diperbarui');
    }

    public function destroy($id) {
        $reservasi = TemuDokter::findOrFail($id);
        
        $reservasi->deleted_by = Auth::id();
        $reservasi->save();
        $reservasi->delete();

        return redirect()->route('Admin.TemuDokter.index')
            ->with('success', 'Data reservasi dihapus');
    }
}