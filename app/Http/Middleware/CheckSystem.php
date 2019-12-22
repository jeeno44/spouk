<?php

namespace App\Http\Middleware;

use Closure;

class CheckSystem
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
        if (!\Auth::check()) {
            /*return redirect()->route('main');*/
            abort(403);
        }
        if (empty(\Auth::user()->college->systems->pluck('id'))) {
            abort(403);
        }
        if (strpos(\Request::root(), 'spo.')) {
            if (!in_array(1, \Auth::user()->college->systems->pluck('id')->toArray())) {
                abort(403);
            }
        }
        if (strpos(\Request::root(), 'vo.')) {
            if (!in_array(2, \Auth::user()->college->systems->pluck('id')->toArray())) {
                abort(403);
            }
        }
        return $next($request);
    }
}
