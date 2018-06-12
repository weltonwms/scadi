<?php
$periodos = ['' => '--Selecione--', 1 => 'Mensal',  5=>'Bimestral', 4=>'Trimestral',2 => 'Semestral', 3 => 'Anual'];
$tipos = ['' => '--Selecione--', 1 => 'Relação',  2 => 'Valor Único', 3 => 'Valor Binário'];
?>
<div class='row'>
    <div class='col-md-6'>
        {!! Form::listCollective(['index_id'=>'Índice *'],$indices,null,['class'=>'meu_chosen']) !!}
        {!! Form::bsText(['sigla'=>"Sigla *"]) !!}
        {!! Form::bsText(['name'=>"Nome *"]) !!}
        {!! Form::listCollective(['periodicidade'=>"Periodicidade *"],$periodos,null,['class'=>'meu_chosen']) !!}
        {!! Form::listCollective(['tipo'=>"Tipo *"],$tipos,null,['class'=>'meu_chosen']) !!}
    </div>

    <div class='col-md-6'>
        {!! Form::bsTextArea(['description'=>"Descrição *"],null,['rows'=>'8']) !!}


        {!! Form::listCollective(['groups_list[]'=>"Grupos Responsáveis"],$groups,null,['multiple'=>'multiple','class'=>'meu_chosen', 'data-placeholder'=>"--Selecione--"]) !!}

    </div>
</div> <!--fim linha1-->
<br>

<div class='row'>
    <div class="col-md-6">
        <div class="panel panel-primary panel-numerador">
            <div class="panel-heading"><b>Numerador</b></div>
            <div class="panel-body">
                {!! Form::bsText(['numerador_sigla'=>"Sigla *"]) !!}
                {!! Form::bsText(['numerador_name'=>"Nome *"]) !!}

                {!! Form::bsText(['numerador_description'=>"Descrição"]) !!}
                <div class="hab-num">
                     <b>Habilitado? </b>  Sim {!! Form::radio('numerador_habilitado',1,true) !!} Não {!! Form::radio('numerador_habilitado',0) !!}
                </div>
               
                <div class='xt1'>
                    <hr>
                    {!! Form::bsText(['numerador_valor_padrao'=>"Valor Padrão *"]) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-primary panel-denominador">
            <div class="panel-heading"><b>Denominador</b></div>
            <div class="panel-body">
                {!! Form::bsText(['denominador_sigla'=>"Sigla *"]) !!}
                {!! Form::bsText(['denominador_name'=>"Nome *"]) !!}

                {!! Form::bsText(['denominador_description'=>"Descrição"]) !!}
                 <div class="hab-den">
                <b>Habilitado? </b>  Sim {!! Form::radio('denominador_habilitado',1,true) !!} Não {!! Form::radio('denominador_habilitado',0) !!}
                 </div>
                
                <div class='xt2'>
                    <hr>
                    {!! Form::bsText(['denominador_valor_padrao'=>"Valor Padrão *"]) !!}
                </div>
            </div>
        </div>
    </div>

</div> <!--fim linha2-->



<div class='row'>
    <div class='col-md-offset-5 col-md-7 '>
        {!! Form::submit("Salvar",['class'=>'btn btn-primary ']) !!}
        <a class="btn btn-default" href="{{route('indicators.index')}}">Cancelar</a>
    </div>
</div> <!--fim linha3-->

<br><br><br>
@push('scripts')
<script src="{{asset('js/form-indicator.js')}}"></script>
@endpush