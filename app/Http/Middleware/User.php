<?php

namespace App\Http\Middleware;

use Closure;

class User
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
        $user=auth()->user();
        if ( !($user->isAdm || $user->isGestor) ) {
            return redirect('home');
        }
        
        if($user->isGestor):
            $userRequest=$request->route('user');
       
            if($userRequest && $userRequest->group_id!=$user->group_id):
                 \Session::flash('mensagem', ['type' => 'danger', 'conteudo' => "Acesso Negado!"]);
                 return redirect()->back();
            endif;
        endif;
        return $next($request);
    }
}
