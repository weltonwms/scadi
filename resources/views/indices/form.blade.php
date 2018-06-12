
<div class="row">
    <div class="col-md-5">
        {!! Form::bsText(['sigla'=>'Sigla *']) !!}
        {!! Form::bsText(['name'=>"Nome *"]) !!}
    </div>

    <div class="col-md-6">
        {!! Form::bsTextArea(['description'=>"Descrição"],null,['rows'=>'5']) !!}
    </div>
</div>


<div class='col-md-offset-4 col-md-8 '>
    {!! Form::submit("Salvar",['class'=>'btn btn-primary ']) !!}
    <a class="btn btn-default" href="{{route('indices.index')}}">Cancelar</a>
</div>
