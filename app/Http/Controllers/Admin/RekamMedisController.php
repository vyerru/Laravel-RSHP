<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\TemuDokter;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekamMedisController extends Controller
{
    public function index() {
        // Ambil rekam medis dengan relasi lengkap
        $rekamMedis = RekamMedis::with([
                'reservasi.pet.pemilik.user', 
                'reservasi.pet.rasHewan',
                'dokter.user'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        // Data untuk Dropdown (Reservasi yang belum punya rekam medis)
        // Kita hanya ambil reservasi yang statusnya 'Diperiksa' (1) atau 'Selesai' (2)
        // Dan belum ada di tabel rekam_medis
        $reservasiTersedia = TemuDokter::with(['pet.pemilik.user'])
            ->whereIn('status', ['1', '2'])
            ->doesntHave('rekamMedis') // Filter: yang belum diperiksa
            ->get();

        // Data Dokter
        $dokter = RoleUser::with('user')
            ->where('idrole', 2)
            ->where('status', 1)
            ->whereHas('user')
            ->get();

        return view('Admin.RekamMedis.index', compact('rekamMedis', 'reservasiTersedia', 'dokter'));
    }

    public function store(Request $request) {
        $request->validate([
            'idreservasi_dokter' => 'required|exists:temu_dokter,idreservasi_dokter|unique:rekam_medis,idreservasi_dokter',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
            'anamnesa' => 'required|string',
            'diagnosa' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Simpan Rekam Medis
            RekamMedis::create([
                'idreservasi_dokter' => $request->idreservasi_dokter,
                'dokter_pemeriksa' => $request->dokter_pemeriksa,
                'anamnesa' => $request->anamnesa,
                'temuan_klinis' => $request->temuan_klinis,
                'diagnosa' => $request->diagnosa,
            ]);

            // 2. Update status reservasi menjadi 'Selesai' (2) otomatis
            $reservasi = TemuDokter::find($request->idreservasi_dokter);
            $reservasi->update(['status' => '2']);
        });

        return redirect()->route('Admin.RekamMedis.index')
            ->with('success', 'Rekam Medis berhasil dibuat.');
    }

    public function update(Request $request, $id) {
        $rm = RekamMedis::findOrFail($id);
        
        $request->validate([
            'anamnesa' => 'required|string',
            'diagnosa' => 'required|string',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
        ]);

        $rm->update([
            'anamnesa' => $request->anamnesa,
            'temuan_klinis' => $request->temuan_klinis,
            'diagnosa' => $request->diagnosa,
            'dokter_pemeriksa' => $request->dokter_pemeriksa,
        ]);

        return redirect()->route('Admin.RekamMedis.index')
            ->with('success', 'Rekam Medis berhasil diperbarui.');
    }

    public function destroy($id) {
        $rm = RekamMedis::findOrFail($id);
        
        $rm->deleted_by = Auth::id();
        $rm->save();
        $rm->delete();

        return redirect()->route('Admin.RekamMedis.index')
            ->with('success', 'Rekam Medis dihapus.');
    }
}