<?php

namespace App\Http\Middleware;

use Closure;

class Adm
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
        
        if (!auth()->user()->isAdm) {
            return redirect('home');
        }
        return $next($request);
    }
}
