<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string $guard): Response
    {
        if ($this->isAuthenticated($request, $guard)) {
            return to_route('dashboard');
        }

        return $next($request);
    }

    private function isAuthenticated(Request $request, string $guard): bool
    {
        return ! $request->wantsJson() && $guard == 'admin' && auth($guard)->check();
    }
}
