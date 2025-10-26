<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemilik;

class PemilikController extends Controller
{
    public function index() {
        $pemilik = Pemilik::with('user')->get(); // Menampilkan data pemiik yang memiiki ID user
        return view('Admin.Pemilik.index', compact('pemilik'));
    }
}
