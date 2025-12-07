<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemuDokterController extends Controller
{
    public function index() {
        $temuDokter = TemuDokter::all();
        return view("Resepsionis.temu-dokter");
    }
}
