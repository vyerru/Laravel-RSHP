<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use illuminate\Support\Facades\Auth;

class isAdministrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = session('user_role');

        if($userRole === 1) {
            return $next($request);
        } else {
            return back()->with('error', 'Akses ditolak. Anda bukan Administrator.');
        }
    }
}
