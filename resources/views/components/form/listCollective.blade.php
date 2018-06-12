<?php
$class = 'form-control ';
if (isset($attributes['class'])):
    $class .= $attributes['class'];
    unset($attributes['class']);
endif;
if (is_array($name)):
    $label = current($name);
    $name = key($name);

else:
    $label = $name;
endif;
$atributos = '';
foreach ($attributes as $key => $attribute):
    $atributos .= "$key=$attribute ";
endforeach;
$class_erro = $errors->has($name) ? 'has-error' : '';
?>

<div class="form-group {{$class_erro}}">
    {{ Form::label($label, null, ['class' => 'control-label']) }}
    {!!Form::select($name, $elements, $value,array_merge(['class'=>$class], $attributes))!!}
    @if($class_erro)
    <span class='help-block'><strong>{{$errors->first($name)}}</strong></span>
    @endif
</div>
