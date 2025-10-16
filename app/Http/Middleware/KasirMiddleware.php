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
        if (Auth::check() && in_array(Auth::user()->hak, ['admin', 'kasir'])) {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Hanya admin atau kasir yang dapat mengakses halaman ini.');
    }
}
