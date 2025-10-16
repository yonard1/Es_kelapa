<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->hak, ['admin', 'kasir'])) {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Hanya admin atau kasir yang dapat mengakses halaman ini.');

    }
}
