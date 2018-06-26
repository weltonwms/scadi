@extends('layouts.app_interno')
@section('content_interno')

<h4>Listagem de Grupos</h4>
<hr>
 
<div class="row">
    <a class="btn btn-primary pull-right" href="{{route('groups.create')}}">Novo Grupo</a>
</div>
 
<table class="tabela table table-striped table-condensed table-hover" id="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
           
           
            
            <th>Ações</th>
          
        </tr>
    </thead>

    <tbody>
        @foreach($groups as $group)
        <tr>
            <td>{{$group->id}}</td>
            <td>{{$group->name}}</td>
            <td>{{$group->description}}</td>
            
           
          
            <td class="col-md-2">
                <a class='btn btn-default' href="{{url("groups/$group->id/edit")}}">Editar</a>
                <a class='btn btn-danger confirm' href="{{url("groups/$group->id")}}  " data-info="{{$group->name}}">Excluir</a>

            </td>
           
        </tr>
        @endforeach


    </tbody>
</table>





@endsection




