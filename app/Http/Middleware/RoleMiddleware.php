<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Kalau middleware ini dipakai tanpa role, biarkan lewat
        if (empty($roles)) {
            return $next($request);
        }

        // Cek berdasarkan kolom 'hak'
        if (!in_array($request->user()->hak, $roles)) {
            if ($request->user()->hak === 'kasir') {
                return redirect()->route('kasir.dashboard');
            } else {
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}
