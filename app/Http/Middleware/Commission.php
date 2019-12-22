<?php

namespace App\Http\Middleware;

use Closure;

class Commission
{
    public function handle($request, Closure $next)
    {
        if (\Auth::user()->is_commission == 0 && !\Auth::user()->hasRole('principal')) {
            abort(404);
        }

        return $next($request);
    }
}
