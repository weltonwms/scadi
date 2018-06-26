
  {!! Form::bsText(['name'=>'Nome *']) !!}
  {!! Form::bsText(['description'=>'Descrição']) !!}
    

<div class='col-md-offset-4 col-md-8 '>
    {!! Form::submit("Salvar",['class'=>'btn btn-primary ']) !!}
    <a class="btn btn-default" href="{{route('groups.index')}}">Cancelar</a>
</div>
