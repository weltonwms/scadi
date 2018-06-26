<?php
$perfis=[''=>'-Selecione-',1=>'Administrador', 2=>"Gestor",3=>'Apurador'];
?>
<div class="row">
<div class="col-md-6">
    {!! Form::bsText(['username'=>"Username (Login) *"]) !!}
{!! Form::bsPassword(['password'=>"Senha (Somente Usuários sem Zimbra)"]) !!}
 {!! Form::bsText(['posto'=>"Posto/Grad "]) !!}
 {!! Form::bsText(['guerra'=>"Nome de Guerra *"]) !!}

</div>

<div class="col-md-6">
   
    {!! Form::bsText(['name'=>"Nome Completo *"]) !!}
    {!! Form::bsText('om') !!}
@if(auth()->user()->isAdm)
{!! Form::listCollective(['perfil'=>"Perfil *"],$perfis,null,['class'=>'meu_chosen']) !!}
{!! Form::listCollective(['group_id'=>"Grupo"],$groups,null,['class'=>'meu_chosen']) !!}
@endif
</div>
</div>

<!--<div class="form-group">
    <label class="control-label">Administrador</label><br>
    <label class="radio-inline">
       {!!Form::radio('adm', '1')!!}  Sim
    </label>
    <label class="radio-inline">
       {!!Form::radio('adm', '0',true)!!}  Não
    </label>
</div>-->


<div class="col-md-8 col-md-offset-4">
    {!! Form::submit("Salvar",['class'=>'btn btn-primary']) !!}
<a class="btn btn-default" href="{{route('users.index')}}">Cancelar</a>
</div>
