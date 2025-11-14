<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = Auth::user()->hak;

        // Kalau user role ada di daftar roles yang diperbolehkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Kalau tidak sesuai role, redirect ke dashboard sesuai role
        if ($userRole === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($userRole === 'kasir') {
            return redirect()->route('kasir.dashboard');
        } else {
            return redirect('/login');
        }
    }
}
