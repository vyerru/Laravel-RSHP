<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodeTindakanTerapi;
use Illuminate\Http\Request;

class KodeTindakanController extends Controller
{
    public function index() {
        $kodeTindakan = KodeTindakanTerapi::with('kategori', 'kategoriKlinis')->get(); 
        return view('Admin.KodeTindakan.index', compact('kodeTindakan'));
    }
}
