<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemilik;
use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PemilikController extends Controller
{
    public function index() {
        // Ambil data pemilik beserta data user-nya
        $pemilik = Pemilik::with('user')->get();
        return view('Admin.Pemilik.index', compact('pemilik'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:6',
            'no_wa' => 'required|string|max:45',
            'alamat' => 'required|string|max:100',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat Akun User
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 2. Assign Role "Pemilik" (ID Role = 5 sesuai database)
            RoleUser::create([
                'iduser' => $user->iduser,
                'idrole' => 5, // 5 adalah ID Role Pemilik
                'status' => 1
            ]);

            // 3. Buat Data Profil Pemilik
            Pemilik::create([
                'iduser' => $user->iduser,
                'no_wa' => $request->no_wa,
                'alamat' => $request->alamat
            ]);
        });

        return redirect()->route('Admin.Pemilik.index')
            ->with('success', 'Data Pemilik berhasil ditambahkan');
    }

    public function update(Request $request, $id) {
        $pemilik = Pemilik::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            // Validasi email unique kecuali punya user ini sendiri
            'email' => 'required|email|unique:user,email,'.$pemilik->iduser.',iduser',
            'no_wa' => 'required|string|max:45',
            'alamat' => 'required|string|max:100',
        ]);

        DB::transaction(function () use ($request, $pemilik) {
            // 1. Update Data User
            $user = User::findOrFail($pemilik->iduser);
            $userData = [
                'nama' => $request->nama,
                'email' => $request->email,
            ];
            
            // Cek password baru
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            
            $user->update($userData);

            // 2. Update Data Profil Pemilik
            $pemilik->update([
                'no_wa' => $request->no_wa,
                'alamat' => $request->alamat
            ]);
        });

        return redirect()->route('Admin.Pemilik.index')
            ->with('success', 'Data Pemilik berhasil diperbarui');
    }

    public function destroy($id) {
        $pemilik = Pemilik::findOrFail($id);
        $user = User::findOrFail($pemilik->iduser);

        DB::transaction(function () use ($pemilik, $user) {
            // Catat siapa yang menghapus
            $idAdmin = Auth::id();
            
            $pemilik->deleted_by = $idAdmin;
            $pemilik->save();
            $pemilik->delete(); // Soft delete pemilik

            $user->deleted_by = $idAdmin;
            $user->save();
            $user->delete(); // Soft delete user juga
        });

        return redirect()->route('Admin.Pemilik.index')
            ->with('success', 'Data Pemilik berhasil dihapus');
    }
}