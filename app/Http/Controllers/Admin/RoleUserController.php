<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleUserController extends Controller
{
    public function index() {
        // Ambil data RoleUser beserta relasinya
        $roleUser = RoleUser::with(['user', 'role'])->get();
        // Ambil semua Role untuk dropdown
        $roles = Role::all();
        
        return view('Admin.RoleUser.index', compact('roleUser', 'roles'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:6',
            'idrole' => 'required|exists:role,idrole',
        ]);

        // Gunakan Transaksi DB agar jika satu gagal, semua batal
        DB::transaction(function () use ($request) {
            // 1. Buat User Baru
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 2. Assign Role ke User tersebut
            RoleUser::create([
                'iduser' => $user->iduser,
                'idrole' => $request->idrole,
                'status' => 1
            ]);
        });

        return redirect()->route('Admin.RoleUser.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, $id) {
        // $id di sini adalah idrole_user (pivot), bukan iduser
        $roleUser = RoleUser::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            // Validasi unik email kecuali milik user ini sendiri
            'email' => 'required|email|unique:user,email,'.$roleUser->iduser.',iduser',
            'idrole' => 'required|exists:role,idrole',
            'status' => 'required|in:1,0', // 1: Aktif, 0: Nonaktif
        ]);

        DB::transaction(function () use ($request, $roleUser) {
            // 1. Update Data User
            $user = User::findOrFail($roleUser->iduser);
            $userData = [
                'nama' => $request->nama,
                'email' => $request->email,
            ];

            // Cek jika password diisi, maka update password
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // 2. Update Role & Status
            $roleUser->update([
                'idrole' => $request->idrole,
                'status' => $request->status
            ]);
        });

        return redirect()->route('Admin.RoleUser.index')
            ->with('success', 'Data User berhasil diperbarui');
    }

    public function destroy($id) {
        // Soft Delete User-nya
        $roleUser = RoleUser::findOrFail($id);
        $user = User::findOrFail($roleUser->iduser);

        // Catat siapa yang menghapus
        $user->deleted_by = Auth::id();
        $user->save();

        // Hapus User (Otomatis RoleUser akan non-fungsional jika User di soft-delete)
        $user->delete();

        return redirect()->route('Admin.RoleUser.index')
            ->with('success', 'User berhasil dihapus (Soft Delete)');
    }
}