@extends('layouts.app_interno')
@section('content_interno')

<h4>Listagem de Indicadores</h4>
<hr>
@if(auth()->user()->isAdm)
<div class="row">
    <a class="btn btn-primary pull-right" href="{{route('indicators.create')}}">Novo Indicador</a>
</div>
@endif

<?php
$periodos = ['' => '--Selecione--', 1 => 'Mensal',  5=>'Bimestral', 4=>'Trimestral',2 => 'Semestral', 3 => 'Anual'];
?>
<div class="row filters">
    <form class="form-inline">
        <?php $attr = ['class' => 'form-control input-sm', 'onchange' => 'this.form.submit()'] ?>
        
        <div class="form-group">
            <label for="">Periodicidade</label>
            
            {!!Form::select('periodicidade', $periodos, null,$attr )!!}
        </div>
         <div class="form-group">
            <label for="">Indice</label>
            
            {!!Form::select('index', $indices, null,$attr )!!}
        </div>
         <div class="form-group">
           <a class="btn btn-default btn-limpar" href="{{route('indicators.index')}}">Limpar</a>
        </div>
       
        

    </form>
</div>
<br>

<table class="tabela table table-striped table-condensed table-hover" id="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>Sigla</th>
            <th>Nome</th>
             <th>Tipo</th>
            <th>Periodicidade</th>
            <th>Índice</th>
            <th>Grupo(s)</th>
            @if(auth()->user()->isAdm)
            <th width='20%'>Ações</th>
            @endif
        </tr>
    </thead>

    <tbody>
        @foreach($indicators as $indicator)
        <tr>
            <td>{{$indicator->id}}</td>
            <td>{{$indicator->sigla}}</td>
            <td>{{$indicator->name}}</td>
             <td>{{$indicator->nome_tipo}}</td>
            <td>{{$indicator->nome_periodicidade}}</td>
            <td>{{$indicator->index->sigla}}</td>
            <td>{{$indicator->getGroupsList()}}</td>
            @if(auth()->user()->isAdm)
            <td>
                <a class='btn btn-default' href="{{url("indicators/$indicator->id/clonar")}}">Clonar</a>
                <a class='btn btn-default' href="{{url("indicators/$indicator->id/edit")}}">Editar</a>
                <a class='btn btn-danger confirm' href="{{url("indicators/$indicator->id")}}  " data-info="{{$indicator->sigla}}">Excluir</a>

            </td>
            @endif
        </tr>
        @endforeach


    </tbody>
</table>





@endsection




