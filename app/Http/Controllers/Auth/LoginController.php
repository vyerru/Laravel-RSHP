<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::with(['RoleUser' => function($query) { 
            $query->where('status', 1);
        }, 'RoleUser.role'])
        ->where('email', $request->input('email'))
        ->first();

        // Untuk Pengecekan Email
        if (!$user) {
            return redirect()->back()
            ->withErrors(['email' => 'Email Tidak Ditemukan.'])
            ->withInput();
        }

        // Untuk Pengecekan Password
        if (!\Hash::check($request->password, $user->password)) {
            return redirect()->back()
            ->withErrors(['password' => 'Password Salah.'])
            ->withInput();
        }

        $namaRole = Role::where('idrole', $user->RoleUser[0]->idrole ?? null)->first();

        Auth::login($user);

        $request->session()->put([
            'user_id' => $user->id,
            'user_name' => $user->nama,
            'user_email' => $user->email,
            'user_role' => $user->RoleUser[0]->idrole ?? 'user',
            'user_role_name' => $namaRole->nama_role ?? 'User',
            'user_status' => $user->RoleUser[0]->status ?? 'active'
        ]);

        $userRole = $user->RoleUser[0]->idrole ?? null;

        switch ($userRole) {
            case 1:
                return redirect()->route('admin.dashboard')->with('success', 'Login Berhasil!');
            case 2:
                return redirect()->route('resepsionis.dashboard')->with('success', 'Login Berhasil!');
            case 3:
                return redirect()->route('dokter.dashboard')->with('success', 'Login Berhasil!');
            case 4:
                return redirect()->route('perawat.dashboard')->with('success', 'Login Berhasil!');
            default:
                return redirect()->route('pemilik.dashboard')->with('success', 'Login Berhasil!');
                
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Logout Berhasil!');
    }

}
