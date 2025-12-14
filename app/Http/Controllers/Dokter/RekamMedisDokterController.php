<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TemuDokter;
use App\Models\RekamMedis;
use App\Models\DetailRekamMedis;
use App\Models\KodeTindakanTerapi;
use App\Models\RoleUser;

class RekamMedisDokterController extends Controller
{
    /**
     * Halaman Periksa Dokter
     * Menampilkan data dari Perawat & Form CRUD Detail
     */
    public function edit($id_reservasi)
    {
        // 1. Ambil Reservasi
        $reservasi = TemuDokter::with(['pet.pemilik.user', 'pet.rasHewan'])->findOrFail($id_reservasi);

        // 2. Ambil Rekam Medis (Yang dibuat Perawat)
        // Jika belum ada (Perawat lupa), buatkan dummy/kosong agar tidak error
        $rekamMedis = RekamMedis::firstOrCreate(
            ['idreservasi_dokter' => $id_reservasi],
            ['dokter_pemeriksa' => null] // Nanti diupdate saat dokter simpan diagnosa
        );

        // 3. Ambil Daftar Tindakan/Terapi (Untuk Dropdown)
        $tindakanList = KodeTindakanTerapi::orderBy('nama_tindakan', 'asc')->get();

        // 4. Ambil Detail Tindakan yang SUDAH diinput (Untuk Tabel List)
        $detailTindakan = DetailRekamMedis::with('tindakan')
            ->where('idrekam_medis', $rekamMedis->idrekam_medis)
            ->get();

        return view('Dokter.RekamMedis.edit', compact('reservasi', 'rekamMedis', 'tindakanList', 'detailTindakan'));
    }

    /**
     * UPDATE DIAGNOSA (Parent)
     */
    public function updateDiagnosa(Request $request, $id_rekam_medis)
    {
        $request->validate(['diagnosa' => 'required']);

        // Ambil ID Dokter Login
        $dokterId = RoleUser::where('iduser', Auth::id())->where('idrole', 2)->value('idrole_user');

        $rm = RekamMedis::findOrFail($id_rekam_medis);
        $rm->update([
            'diagnosa' => $request->diagnosa,
            'dokter_pemeriksa' => $dokterId, // Update dokter pemeriksa jadi dokter ini
        ]);

        // Update status reservasi jadi Selesai
        TemuDokter::where('idreservasi_dokter', $rm->idreservasi_dokter)
            ->update(['status' => '2']);

        return redirect()->route('Dokter.Dashboard.index')
            ->with('success', 'Pemeriksaan Selesai.');
    }

    /**
     * CREATE DETAIL (Menambah Tindakan)
     */
    public function storeDetail(Request $request)
    {
        $request->validate([
            'idrekam_medis' => 'required',
            'idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
        ]);

        DetailRekamMedis::create([
            'idrekam_medis' => $request->idrekam_medis,
            'idkode_tindakan_terapi' => $request->idkode_tindakan_terapi,
            'detail' => $request->detail, // Catatan tambahan (opsional)
        ]);

        return redirect()->back()->with('success', 'Tindakan berhasil ditambahkan.');
    }

    /**
     * DELETE DETAIL (Menghapus Tindakan)
     */
    public function destroyDetail($id)
    {
        $detail = DetailRekamMedis::findOrFail($id);
        $detail->delete();

        return redirect()->back()->with('success', 'Tindakan dihapus.');
    }
}