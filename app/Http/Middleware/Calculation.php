<?php

namespace App\Http\Middleware;

use Closure;

class Calculation
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
        $indicator=$request->route('indicator');
        
        $groups=$indicator->groups->pluck('id');
        $userGroup=auth()->user()->group_id;
        
        if(!$groups->contains($userGroup)):
             \Session::flash('mensagem', ['type' => 'danger', 'conteudo' => "Acesso Negado!"]);
           return redirect('calculations');
        endif;
        
        return $next($request);
    }
}
