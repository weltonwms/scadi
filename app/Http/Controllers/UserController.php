<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use App\Group;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $dados=[
            'users'=> User::CustomByFilter()->get(),
            'postos'=>User::getTodosPostos()->prepend('--Selecione--',0),
            'oms'=>User::getTodasOms()->prepend('--Selecione--',0),
            'groups'=>Group::all()->pluck('name','id')->prepend('--Selecione--','')
        ];
        
        return view("users.index", $dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $dados = ['groups' => \App\Group::pluck('name', 'id')->prepend('-Selecione-', '')];
        return view('users.create', $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request) {

        $newUser = User::create($this->tratarDadosRequest($request));
        
        $newUser->save();

        if ($newUser->id):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionCreate')]);
        endif;
        return redirect()->route("users.index");
    }

    
    public function show($id) {
       return $id;
    }

   
    public function edit(User $user) {
        $dados = ['groups' => \App\Group::pluck('name', 'id')->prepend('-Selecione-', ''),
            'user' => $user
        ];
        return view('users.edit', $dados);
    }

    
    public function update(UserRequest $request, User $user) {
        //dd($request->all());
        $user->update($this->tratarDadosRequest($request));
       
        $retorno = $user->save();

        if ($retorno):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionUpdate')]);
        endif;
        return redirect()->route("users.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        $retorno = $user->VerifyAndDelete();
        if ($retorno):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionDelete')]);
        endif;
        return redirect()->route('users.index');
    }
    
    private function tratarDadosRequest($request){
        $dados1 = $this->tratarPerfil($request->all());
        $dados2= $this->tratarPassword($dados1);
        return $dados2;
    }
    
    private function tratarPassword(array $dados) {
        
        if ($dados['password']):
            $dados['password'] = bcrypt($dados['password']);
        else:
            unset($dados['password']);
        endif;
        return $dados;
    }
    
       
    private function tratarPerfil(array $dados){
        if(auth()->user()->isAdm):
            return $dados;
        endif;
        $routeName=request()->route()->getName();
        if(auth()->user()->isGestor && $routeName=="users.store"):
            $dados['perfil']=3;
            $dados['group_id']=auth()->user()->group_id;
            return $dados;
        endif;
        //impedir usuários não autorizados de trocarem o perfil e grupo
        unset($dados['perfil']);
        unset($dados['group_id']);
        
        return $dados;
    }

    public function usersLdap() {
        return view('users.ldap');
    }

    public function getMilitaresJson() {
        $militares = \App\Helpers\Ldap::getMilitares();
        return $militares;
    }
    
    public function lixeira(){
        $users= User::onlyTrashed()->get();
        $dados=[
          "users"=>$users  
        ];
        return view("users.lixeira", $dados);
    }
    
    public function reativar($user_id){
        $user= User::onlyTrashed()->find($user_id);
       
        if($user):
            $user->restore();
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => 'Usuário Reativado']);
        endif;
        return redirect()->route('users.lixeira');
    }

}
