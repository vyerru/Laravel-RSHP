<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class pemilik
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userRole = session('user_role');

        if($userRole === 5) {
            return $next($request);
        } else {
            return back()->with('error', 'Akses ditolak. Anda bukan Pemilik.');
        }
    }
}