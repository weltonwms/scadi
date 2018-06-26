<?php
$class_input='form-control ';
if(isset($attributes['class'])):
    $class_input.=$attributes['class'];
    unset($attributes['class']);
endif;
if(is_array($name)):
    $label=current($name);
    $name=key($name);
   
 else:
    $label=$name;
endif;
$class_erro = $errors->has($name) ? 'has-error' : '';

?>
<div class="form-group {{$class_erro}}">
    {{ Form::label($label, null, ['class' => 'control-label']) }}
    {{ Form::textarea($name, $value, array_merge(['class' => $class_input], $attributes)) }}
    @if($class_erro)
        <span class='help-block'><strong>{{$errors->first($name)}}</strong></span>
    @endif
</div>
