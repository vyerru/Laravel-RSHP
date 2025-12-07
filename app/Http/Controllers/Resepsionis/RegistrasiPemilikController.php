<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Pemilik;
use Illuminate\Http\Request;

class RegistrasiPemilikController extends Controller
{
    public function index() {
        $Pemilik = Pemilik::with('user')->get();
        return view("Resepsionis.registrasi-pemilik", compact('Pemilik'));
    }
}
