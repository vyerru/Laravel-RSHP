<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Builder\Function_;

class SiteController extends Controller
{
    public function index()
    {
        return view('Site.home');
    }

    public function layanan() {
        return view('Site.layanan');
    }

    public function login(){

    }

    public function tentang() {
        
    }

    public function cekKoneksi() {
        try {
            \DB::connection()->getPdo();
            echo "Koneksi database berhasil!";
        } catch (\Exception $e) {
            echo "Koneksi database gagal: " . $e->getMessage();
        }
    }
}
