<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSeeker
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'seeker') {
            return $next($request);
        }

        abort(403, 'Access denied. You must be a job seeker to access this page.');
    }
}
