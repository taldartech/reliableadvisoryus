<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $allowed = ['Super Admin', 'Admin', 'Store Manager', 'Ecommerce Admin'];
        if (! $request->user()->roles()->whereIn('role_name', $allowed)->exists()) {
            abort(403, 'Access denied. Admin role required.');
        }

        return $next($request);
    }
}
