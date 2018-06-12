<?php
$class='form-control ';
if(isset($attributes['class'])):
    $class.=$attributes['class'];
    unset($attributes['class']);
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
    <select name="{{$name}}"  class="{{$class}}" {{$atributos}}>
    @foreach($elements as $key=>$element)
    <option value="{{$key}}"
       
        <?php echo $value == $key ? "selected='selected'" : '' ?>
        
        >{{$element}}</option>
    @endforeach

</select>
</div>
