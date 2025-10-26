<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisHewan;

class JenisHewanController extends Controller
{
    public function index() {
        $jenisHewan = JenisHewan::all(); //Menampilkan semua data yang tersedia
        return view('Admin.JenisHewan.index', compact('jenisHewan'));
    }
}
