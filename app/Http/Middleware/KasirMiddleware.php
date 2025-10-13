<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class KasirMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hak === 'kasir') {
            return $next($request);
        }

        // Kalau bukan kasir, arahkan ke dashboard atau halaman lain
        return redirect()->route('home')->with('error', 'Akses ditolak. Hanya untuk kasir.');
    }
}
