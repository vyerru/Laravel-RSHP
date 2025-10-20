<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Pemilik extends Controller
{
    public function index() {
        return view('Admin.pemilik');
    }
}
