<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $locale = session('locale', config('app.locale'));
            App::setLocale($locale);
        } catch (\Exception $e) {
            App::setLocale(config('app.locale'));
        }
        return $next($request);
    }
}
