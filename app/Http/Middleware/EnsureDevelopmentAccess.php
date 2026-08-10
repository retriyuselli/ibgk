<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDevelopmentAccess
{
    /** @var list<string> */
    private array $exemptRoutes = [
        'home',
        'login',
        'login.store',
        'register',
        'register.store',
        'auth.google',
        'auth.google.callback',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! config('site.under_development') || $request->user()) {
            return $next($request);
        }

        if ($request->routeIs(...$this->exemptRoutes)) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
