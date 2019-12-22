<?php

namespace App\Http\Middleware;

use Closure;

class Principal
{
    public function handle($request, Closure $next)
    {
        if (!\Auth::user()->hasRole('principal')) {
            abort(404);
        }

        return $next($request);
    }
}
