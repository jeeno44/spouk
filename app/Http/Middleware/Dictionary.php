<?php

namespace App\Http\Middleware;

use Closure;

class Dictionary
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
        if (!\Auth::user()->hasRole('admin') &&  !\Auth::user()->hasRole('principal')) {
           abort(404);
        }

        return $next($request);
    }
}
