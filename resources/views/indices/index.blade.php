@extends('layouts.app_interno')
@section('content_interno')

<h4>Listagem de Índices</h4>
<hr>
 @if(auth()->user()->isAdm)
<div class="row">
    <a class="btn btn-primary pull-right" href="{{route('indices.create')}}">Novo Índice</a>
</div>
 @endif
<table class="tabela table table-striped table-condensed table-hover" id="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>Sigla</th>
            <th>Nome</th>
           
           
            @if(auth()->user()->isAdm)
            <th>Ações</th>
            @endif

        </tr>
    </thead>

    <tbody>
        @foreach($indices as $index)
        <tr>
            <td>{{$index->id}}</td>
            <td>{{$index->sigla}}</td>
            <td>{{$index->name}}</td>
            
           
            @if(auth()->user()->isAdm)
            <td class="col-md-2">
                <a class='btn btn-default' href="{{url("indices/$index->id/edit")}}">Editar</a>
                <a class='btn btn-danger confirm' href="{{url("indices/$index->id")}}  " data-info="{{$index->sigla}}">Excluir</a>

            </td>
            @endif
        </tr>
        @endforeach


    </tbody>
</table>





@endsection




