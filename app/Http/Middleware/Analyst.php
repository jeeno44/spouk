<?php

namespace App\Http\Middleware;

use Closure;

class Analyst
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!\Auth::user()->hasRole('analyst')) {
            abort(404);
        }

        return $next($request);
    }
}
