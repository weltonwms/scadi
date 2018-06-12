<?php

$class='form-control ';
if(isset($attributes['class'])):
    $class.=$attributes['class'];
    unset($attributes['class']);
endif;
if(!$value):
    $value=[];
endif;

if(is_array($name)):
    $label=current($name);
    $name=key($name);
   
 else:
    $label=$name;
endif;

$atributos='';
foreach ($attributes as $key=>$attribute):
    $atributos.="$key=$attribute ";
endforeach;
//echo $atributos; exit();
?>

<div class="form-group">
    {{ Form::label($label, null, ['class' => 'control-label']) }}
    <select name="{{$name}}" multiple='multiple' class="{{$class}}" {{$atributos}}>
    @foreach($elements as $key=>$element)
    <option value="{{$key}}"
        @foreach($value as $val)
        <?php echo $val == $key ? "selected='selected'" : '' ?>
        @endforeach
        >{{$element}}</option>
    @endforeach

</select>
</div>

