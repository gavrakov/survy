<?php

namespace App\Http\Middleware;

use Closure;

class CheckLocation
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
        if (session('location') == null) {
            return redirect('/plans/notiflocation');
        }
        return $next($request);
    }
}
