@extends('layouts.app_interno')
@section('content_interno')

<h4>Listagem de Usuários</h4>
<hr>
<div class="row">
    <a class="btn btn-primary pull-right" href="{{route('users.create')}}">Novo Usuário</a>
</div>

<div class="row filters">
    <form class="form-inline">
        <?php $attr = ['class' => 'form-control input-sm', 'onchange' => 'this.form.submit()'] ?>
         <?php $perfis = [''=>'--Selecione--',1=>"Administrador", 2=>"Gestor",3=>"Apurador"];?>
        <div class="form-group">
            <label for="">Om</label>
            
            {!!Form::select('om', $oms, null,$attr )!!}
        </div>
         <div class="form-group">
            <label for="">Posto/Grad</label>
            
            {!!Form::select('posto', $postos, null,$attr )!!}
        </div>
        @if(auth()->user()->isAdm)
         <div class="form-group">
            <label for="">Grupo</label>
            
            {!!Form::select('group', $groups, null,$attr )!!}
        </div>
        <div class="form-group">
            <label for="">Perfil</label>
            
            {!!Form::select('perfil', $perfis, null,$attr )!!}
        </div>
        @endif
         <div class="form-group">
           
            <a class="btn btn-default btn-limpar" href="{{route('users.index')}}">Limpar</a>
        </div>
        

    </form>
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
                <a class='btn btn-default' href="{{url("users/$user->id/edit")}}">Editar</a>
                <a class='btn btn-danger confirm' href="{{url("users/$user->id")}}  " data-info="{{$user->name}}">Excluir</a>

            </td>
        </tr>
        @endforeach


    </tbody>
</table>

@endsection




