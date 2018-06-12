<?php

$disabled_numerador=!$indicator->numerador_habilitado?['disabled'=>'disabled']:[];
$valor_numerador=!$indicator->numerador_habilitado?$indicator->numerador_valor_padrao:null;
$obs_numerador=!$indicator->numerador_habilitado?'Valor Padrão':null;

$disabled_denominador=!$indicator->denominador_habilitado?['disabled'=>'disabled']:[];
$valor_denominador=!$indicator->denominador_habilitado?$indicator->denominador_valor_padrao:null;
$obs_denominador=!$indicator->denominador_habilitado?'Valor Padrão':null;
$nome_numerador=$indicator->tipo==1?"Numerador":"Variável";
$valoresBinarios = ['' => '--Selecione--',1 => 'Sim',  0 => 'Não'];
?>
<div class='row'>
    <div class='col-md-4'>
          <p><b>Periodicidade</b>: {{$indicator->nome_periodicidade}}</p>
         @include('calculations.field_data')        
         <p ><b>Nome</b>: {{$indicator->name}}</p>
         <p ><b>Tipo</b>: {{$indicator->nome_tipo}}</p>
         <p><b>Descrição</b></p>
         <p>{!!$indicator->description!!} </p>
    </div><!--fim primeira coluna-->

    
    
    <div class='col-md-8'>
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>{{$nome_numerador}}: </b>  {{$indicator->numerador_sigla}}<br>
                {{$indicator->numerador_name}}
            </div>
            <div class="panel-body">
                <div class="col-md-6">
                    @if($indicator->tipo==3)
                        {!! Form::listCollective(['valor_numerador'=>"Valor *"],$valoresBinarios,null,['class'=>'meu_chose']) !!}
                    @else
                        {!! Form::bsText(['valor_numerador'=>"Valor *"],$valor_numerador,$disabled_numerador) !!}
                    @endif
                    
                    {!! Form::bsText(['obs_numerador'=>"Observação"],$obs_numerador,$disabled_numerador) !!}
                </div>
                <div class="col-md-6">
                    <b>Descrição</b><br><br>
                    {!!$indicator->numerador_description!!}
                </div>
            </div>
        </div>
        @if($indicator->tipo==1)
       <div class="panel panel-default">
            <div class="panel-heading">
                <b>Denominador:</b> {{$indicator->denominador_sigla}}<br>
                {{$indicator->denominador_name}}
            </div>
            <div class="panel-body">
                <div class="col-md-6">
                    {!! Form::bsText(['valor_denominador'=>"Valor *"],$valor_denominador,$disabled_denominador) !!}
                    {!! Form::bsText(['obs_denominador'=>"Observação"],$obs_denominador,$disabled_denominador) !!}
                </div>
                <div class="col-md-6">
                    <b>Descrição</b><br><br>
                    {!!$indicator->denominador_description!!}
                </div>
            </div>
        </div>
        @endif
    </div><!--fim segunda coluna-->
    
   

</div>


<div class='row'>
    <div class='col-md-offset-5 col-md-7 '>
       
        <btn id='btn-repetir-lancamento' class='btn btn-default'>Repetir Lançamento Anterior</btn>
         {!! Form::submit("Salvar",['class'=>'btn btn-primary ']) !!}
        <a class="btn btn-default" href="{{route('calculations.index')}}">Cancelar</a>
    </div>
</div> <!--fim linha2-->

@push('scripts')
<script src="{{asset("/js/bootbox.min.js")}}"></script>
<script src="{{asset("/js/calculations.js")}}"></script>
@endpush







