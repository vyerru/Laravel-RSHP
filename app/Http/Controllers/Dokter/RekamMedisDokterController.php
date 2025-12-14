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
    // 1. List Riwayat Pemeriksaan Saya
    public function index()
    {
        $dokterId = RoleUser::where('iduser', Auth::id())->where('idrole', 2)->value('idrole_user');

        $rekamMedis = RekamMedis::with(['reservasi.pet.pemilik.user', 'reservasi.pet.rasHewan'])
            ->where('dokter_pemeriksa', $dokterId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('Dokter.RekamMedis.index', compact('rekamMedis'));
    }

    // 2. Halaman Form Periksa (Edit Data Perawat)
    public function edit($id_reservasi)
    {
        $reservasi = TemuDokter::with(['pet.pemilik.user', 'pet.rasHewan'])->findOrFail($id_reservasi);

        // --- PERBAIKAN DI SINI ---
        // Ambil ID Dokter dari data Reservasi agar tidak error "Column cannot be null"
        $dokterId = $reservasi->idrole_user; 

        // Gunakan firstOrCreate dengan data default yang lengkap
        $rekamMedis = RekamMedis::firstOrCreate(
            ['idreservasi_dokter' => $id_reservasi],
            [
                'dokter_pemeriksa' => $dokterId, // Isi dengan dokter yang dituju
                
                // Kita isi strip (-) untuk jaga-jaga jika kolom ini juga NOT NULL di database Anda
                'anamnesa' => '-', 
                'temuan_klinis' => '-',
                'diagnosa' => 'Belum diisi dokter' 
            ] 
        );
        // -------------------------

        // Update status reservasi jadi 'Diperiksa' (1)
        if ($reservasi->status == '0') {
            $reservasi->update(['status' => '1']);
        }

        $tindakanList = KodeTindakanTerapi::orderBy('deskripsi_tindakan_terapi', 'asc')->get();
        $detailTindakan = DetailRekamMedis::with('tindakan')->where('idrekam_medis', $rekamMedis->idrekam_medis)->get();

        return view('Dokter.RekamMedis.edit', compact('reservasi', 'rekamMedis', 'tindakanList', 'detailTindakan'));
    }

    // 3. Simpan Diagnosa & Selesai
    public function updateDiagnosa(Request $request, $id)
    {
        $request->validate(['diagnosa' => 'required']);
        $dokterId = RoleUser::where('iduser', Auth::id())->where('idrole', 2)->value('idrole_user');

        $rm = RekamMedis::findOrFail($id);
        $rm->update([
            'diagnosa' => $request->diagnosa,
            'dokter_pemeriksa' => $dokterId,
        ]);

        TemuDokter::where('idreservasi_dokter', $rm->idreservasi_dokter)->update(['status' => '2']); // Selesai

        return redirect()->route('Dokter.Dashboard.index')->with('success', 'Pemeriksaan Selesai.');
    }

    // 4. Tambah Detail Tindakan
    public function storeDetail(Request $request)
    {
        $request->validate([
            'idrekam_medis' => 'required',
            'idkode_tindakan_terapi' => 'required',
        ]);

        DetailRekamMedis::create($request->all());
        return redirect()->back()->with('success', 'Tindakan ditambahkan.');
    }

    // 5. Hapus Detail Tindakan
    public function destroyDetail($id)
    {
        DetailRekamMedis::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Tindakan dihapus.');
    }
}