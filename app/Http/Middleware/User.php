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
      //impedindo acesso a qualquer um que não seja adm ou gestor
        if ( !($user->isAdm || $user->isGestor) ) {
            return redirect('home');
        }
        
      //verificando o que o gestor pode acessar
        if($user->isGestor):
           //impedindo rotas de lixeira ou reativar 
            $nome_rota=$request->route()->getName();
            if($nome_rota=="users.lixeira" || $nome_rota=="users.reativar"){
                \Session::flash('mensagem', ['type' => 'danger', 'conteudo' => "Ação não autorizada para Gestor!"]);
                 return redirect()->back();
            }
            
            //impedindo o gestor de modificar usuário que não seja do seu grupo.
            //O gestor tem todas as permissões com o usuário de seu grupo. Ou seja, ele pode excluir, editar, etc.
            $userRequest=$request->route('user');
            if($userRequest && $userRequest->group_id!=$user->group_id):
                 \Session::flash('mensagem', ['type' => 'danger', 'conteudo' => "Acesso Negado!"]);
                 return redirect()->back();
            endif;
        endif;
        //permitindo o proximo passo, caso o fluxo chegue até aqui.
        return $next($request);
    }
}
