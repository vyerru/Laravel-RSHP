<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;

class RegistrasiPetController extends Controller
{
    public function index() {
        $pet = Pet::all();
        return view("Resepsionis.registrasi-pet");
    }
}
