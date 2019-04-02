@extends('layouts.app_interno')
@section('content_interno')

<h4>Listagem de Usuários Excluídos</h4>
<hr>
<div class="row">
    <a class="btn btn-default pull-right" href="{{route('users.index')}}">Voltar para Usuários Ativos</a>
</div>


<br>

<table class="tabela table table-striped table-condensed  table-hover" id="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nome</th>
             <th width="15%">Nome de Guerra</th>
              <th>Posto</th>
            <th>OM</th>
            <th>Perfil</th>
            <th>Grupo</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->username}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->guerra}}</td>
            <td>{{$user->posto}}</td>
            <td>{{$user->om}}</td>
             <td>{{$user->nome_perfil}}</td>
             <td>{{$user->getGroupName()}}</td>
            
            <td class="col-md-2">
                <a class='btn btn-default confirm_reativar' href="{{url("users/$user->id/reativar")}}">Reativar</a>
               

            </td>
        </tr>
        @endforeach


    </tbody>
</table>

@endsection




