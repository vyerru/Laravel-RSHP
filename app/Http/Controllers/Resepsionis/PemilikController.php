<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Pemilik;
use App\Models\RoleUser;
use App\Models\Pet; // Untuk show detail
use App\Models\RasHewan; // Untuk dropdown di detail nanti

class PemilikController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pemilik = Pemilik::with('user')
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })->orWhere('no_wa', 'like', "%{$search}%");
            })
            ->orderBy('idpemilik', 'desc')
            ->paginate(10);

        return view('Resepsionis.Pemilik.index', compact('pemilik'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email',
            'no_wa' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat User
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make('123456'), // Default Password
            ]);

            // 2. Assign Role Pemilik (idrole = 5)
            RoleUser::create([
                'iduser' => $user->iduser,
                'idrole' => 5, // 5 = Pemilik
                'status' => 1
            ]);

            // 3. Buat Data Profil Pemilik
            Pemilik::create([
                'iduser' => $user->iduser,
                'no_wa' => $request->no_wa,
                'alamat' => $request->alamat,
            ]);
        });

        return redirect()->back()->with('success', 'Pemilik baru berhasil didaftarkan. Password default: 123456');
    }

    public function update(Request $request, $id)
    {
        $pemilik = Pemilik::findOrFail($id);
        $pemilik->update([
            'no_wa' => $request->no_wa,
            'alamat' => $request->alamat,
        ]);
        
        $pemilik->user->update(['nama' => $request->nama]);

        return redirect()->back()->with('success', 'Data pemilik diperbarui.');
    }

    // Detail Pemilik (Halaman untuk tambah Hewan)
    public function show($id)
    {
        // 1. Ambil Data Pemilik & Hewannya
        $pemilik = Pemilik::with(['user', 'pets.rasHewan.jenisHewan'])->findOrFail($id);
        
        // 2. Ambil Master Data Ras Hewan (Untuk Dropdown Tambah Hewan)
        $rasHewan = RasHewan::with('jenisHewan')->orderBy('nama_ras', 'asc')->get();

        // 3. Ambil Daftar Dokter Aktif (Untuk Dropdown Pendaftaran)
        $dokterList = RoleUser::with('user')
            ->where('idrole', 2)
            ->where('status', 1)
            ->whereHas('user') // <--- INI KUNCINYA
            ->get();

        return view('Resepsionis.Pemilik.show', compact('pemilik', 'rasHewan', 'dokterList'));
    }
}