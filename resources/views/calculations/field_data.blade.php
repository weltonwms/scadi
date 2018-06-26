<?php

use App\Helpers\CalculationDate;

$mes_atual = CalculationDate::getMesAtual();
$ano_atual = CalculationDate::getAnoAtual();
$semestre_atual = CalculationDate::getSemestreAtual();
$trimestre_atual = CalculationDate::getTrimestreAtual();
$bimestre_atual = CalculationDate::getBimestreAtual();
$double_input = $indicator->periodicidade ==3?'': 'input-group double-input';
?>
<div class="form-group">
    <label for="">Período de Referência da Apuração</label>
    <div class="{{$double_input}}">
        @if($indicator->periodicidade==1)
        {!! Form::select('data_mes',CalculationDate::getMeses(),$mes_atual,['class'=>'form-control meu_chose']) !!}
        @endif
        @if($indicator->periodicidade==2)
        {!! Form::select('data_semestre',CalculationDate::getSemestres(),$semestre_atual,['class'=>'form-control meu_chose']) !!}
        @endif
        @if($indicator->periodicidade==4)
        {!! Form::select('data_trimestre',CalculationDate::getTrimestres(),$trimestre_atual,['class'=>'form-control meu_chose']) !!}
        @endif
        @if($indicator->periodicidade==5)
        {!! Form::select('data_bimestre',CalculationDate::getBimestres(),$bimestre_atual,['class'=>'form-control meu_chose']) !!}
        @endif

        {!! Form::select('data_ano',CalculationDate::getAnos(),$ano_atual,['class'=>'form-control meu_chose']) !!}

    </div><!-- /input-group -->

</div>



