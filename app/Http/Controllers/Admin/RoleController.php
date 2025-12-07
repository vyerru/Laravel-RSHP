<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::all();
        return view('Admin.Role.index', compact('roles'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_role' => 'required|string|max:100|unique:role,nama_role',
        ]);

        Role::create([
            'nama_role' => $request->nama_role
        ]);

        return redirect()->route('Admin.Role.index')
            ->with('success', 'Role berhasil ditambahkan');
    }

    public function update(Request $request, $id) {
        $role = Role::findOrFail($id);
        
        $request->validate([
            // Validasi unique kecuali untuk id yang sedang diedit
            'nama_role' => 'required|string|max:100|unique:role,nama_role,'.$role->idrole.',idrole',
        ]);

        $role->update([
            'nama_role' => $request->nama_role
        ]);

        return redirect()->route('Admin.Role.index')
            ->with('success', 'Role berhasil diperbarui');
    }

    public function destroy($id) {
        $role = Role::findOrFail($id);
        
        // Cek apakah role sedang dipakai? (Opsional, untuk keamanan data)
        if($role->roleUser()->exists()) {
            return redirect()->back()->withErrors(['Masih ada User yang menggunakan Role ini. Hapus/Pindahkan user terlebih dahulu.']);
        }

        // Catat siapa yang menghapus
        $role->deleted_by = Auth::id();
        $role->save();
        
        // Soft Delete
        $role->delete();

        return redirect()->route('Admin.Role.index')
            ->with('success', 'Role berhasil dihapus');
    }
}