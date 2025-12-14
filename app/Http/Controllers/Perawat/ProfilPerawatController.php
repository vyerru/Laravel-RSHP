<?php
namespace App\Http\Controllers\Perawat;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Perawat;

class ProfilPerawatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $perawat = Perawat::firstOrCreate(
            ['id_user' => $user->iduser],
            ['alamat' => '-', 'no_hp' => '-', 'pendidikan' => 'D3 Keperawatan']
        );
        return view('Perawat.Profil.index', compact('user', 'perawat'));
    }
}