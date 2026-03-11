<?php

namespace App\Http\Middleware;

use App\Services\HapApiService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHapAdmin
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->api->isAuthenticated()) {
            return redirect()->route('admin.login')->with('error', 'Please log in.');
        }
        return $next($request);
    }
}
