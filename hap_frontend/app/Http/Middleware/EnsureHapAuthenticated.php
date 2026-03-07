<?php

namespace App\Http\Middleware;

use App\Services\HapApiService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHapAuthenticated
{
    public function __construct(
        protected HapApiService $api
    ) {}

    /**
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->api->isAuthenticated()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        return $next($request);
    }
}
