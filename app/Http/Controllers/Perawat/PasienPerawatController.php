<?php
namespace App\Http\Controllers\Perawat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet;

class PasienPerawatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $pets = Pet::with(['pemilik.user', 'rasHewan'])
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%");
            })
            ->orderBy('nama', 'asc')->paginate(10);

        return view('Perawat.Pasien.index', compact('pets'));
    }
}