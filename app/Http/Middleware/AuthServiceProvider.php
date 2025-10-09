<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Gate;

class AuthServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function ($user) {
            return $user->hak === 'admin';
        });

        Gate::define('isKasir', function ($user) {
            return $user->hak === 'kasir';
        });
}
}
