@extends('layouts.app_interno')
@section('content_interno')

<h4>Apurações</h4>
<hr>
<?php
$periodos = ['' => '--Selecione--', 1 => 'Mensal',  5=>'Bimestral', 4=>'Trimestral',2 => 'Semestral', 3 => 'Anual'];
?>
 <form class="form-inline">
<div class="row ">
    <div class=" filters col-md-12">
         <div class="form-group">
            <label for="">Indicador: </label>
            <?php $attr = ['class' => 'form-control input-sm', 'onchange' => 'this.form.submit()'] ?>
            {!!Form::select('indicator', $indicators, null,$attr )!!}
        </div>
        <div class="form-group">
            <label for="">Periodicidade: </label>

            {!!Form::select('periodicidade', $periodos, null,$attr )!!}
        </div>
       
        <div class="form-group">
             <label for="">Usuário: </label>
            <div class="input-group">
                <input class="form-control input-sm" name="name" placeholder="Nome" value="{{request('name')}}">
                <span class="input-group-btn">
                    <button class="btn btn-sm btn-default" type="submit">Buscar</button>
                </span>
            </div>
        </div>
         <div class="form-group">
           
            <a class="btn btn-default btn-limpar" href="{{route('historics.index')}}">Limpar</a>
        </div>
    </div>
       

    
</div>
<br>

<div class="row">
    <div class="col-md-6" style="padding-top: 7px;">
        <?php $total = $calculations->count() ? $calculations->total() : 0 ?>
    Mostrando <b>{{$calculations->count()}}</b>  de <b>{{$total}}</b> registro(s)
    </div>
    <div class="col-md-6">
        <div class="pull-right">
            <?php $valLimit= request('limitPage')?request('limitPage'):10?>
            Mostrar {!!Form::select('limitPage', [10=>10,25=>25,50=>50,100=>100], $valLimit,['class'=>"form-control input-sm",'onchange'=>"form.submit()"] )!!} registros por página
        </div>
        
    </div>
    
</div>
</form>

{!! Form::open(['name'=>'form-apuracoes','route'=>['historics.validar'],'class'=>'','method'=>'PUT'])!!}
<div class="row">
    <div class="col-md-12" style="margin-top: 10px">
         <button type="submit" class='btn btn-primary pull-right' id='btn-valida-apuracoes'>Validar Apurações</button>
    </div>
   
</div>

<table class="table table-striped table-condensed table-hover " id="tabela-historico">
    <thead>
        <tr>
            <th>
                <input title="Marcar Todos" data-toggle="tooltip"
                       class="check_all" type="checkbox"/>
            </th>
<!--            <th>Id</th>-->
            <th>Indicador</th>
              <th>Periodicidade</th>
            <th>Período Referência</th>
          
            <th>Valor</th>
            <th>Observações</th>
           
            <th>Criado por</th>
            <th>Validado por</th>


        </tr>
    </thead>

    <tbody>
        @foreach($calculations as $calculation)
        <?php $classDanger = $calculation->validado ? '' : 'danger' ?>
        <tr class="{{$classDanger}}">
            <td>
                @if(!$calculation->validado)
                <input class="checados" value="{{$calculation->id}}" name="validar[]" type="checkbox"/>
                @endif
            </td>
<!--            <td>{{$calculation->id}}</td>-->
            <td>{{$calculation->indicator->sigla}}</td>
            <td>{{$calculation->indicator->nome_periodicidade}}</td>
            <td>{{$calculation->getPeriodoReferencia()}}</td>
            
            <td>{{$calculation->getValor()}}</td>
            <td>{{$calculation->getObservacoes()}}</td>
            
            <td>{{$calculation->getCriadoPor()}}</td>
             <td>{{$calculation->getValidadoPor()}}</td>




        </tr>
        @endforeach


    </tbody>
</table>
{!! Form::close() !!}
<?php
$append = [
    'indicator' => request('indicator'),
    'periodicidade' => request('periodicidade'),
    'user' => request('user'),
    'name' => request('name'),
    'limitPage'=>request('limitPage')
        ]
?>
@if($calculations->count())
{{ $calculations->appends($append)->links() }}
@endif

@endsection

@push('scripts')
<script src="{{asset("/js/bootbox.min.js")}}"></script>
<script src="{{asset("/js/historico.js")}}"></script>
@endpush




