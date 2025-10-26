<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index() {
        $pet = Pet::all(); 
        return view('Admin.Pet.index', compact('pet'));
    }
}
