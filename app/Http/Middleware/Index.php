<?php

namespace App\Http\Middleware;

use Closure;

class Index
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
        if ( !(auth()->user()->isAdm || auth()->user()->isGestor) ) {
            return redirect('home');
        }
        return $next($request);
    }
}
