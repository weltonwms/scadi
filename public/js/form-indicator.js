$(document).ready(function () {

    $('input[name=numerador_habilitado]').change(function () {
        var value = $(this).val();
       
        if (value == 0) {
            //$('input[name=numerador_valor_padrao]').attr('required', 'required');
            $('.xt1').show();
        } else {
            //$('input[name=numerador_valor_padrao]').removeAttr('required');
            $('.xt1').hide();
        }
    });


    $('input[name=denominador_habilitado]').change(function () {
        var value = $(this).val();
       
        if (value == 0) {
            //$('input[name=denominador_valor_padrao]').attr('required', 'required');
            $('.xt2').show();
        } else {
            //$('input[name=denominador_valor_padrao]').removeAttr('required');
            $('.xt2').hide();
        }
    });
    
     $('select[name=tipo]').change(function () {
        var value = $(this).val();
        
        if (value == 2 || value ==3 ) {
            
            $('.panel-denominador').hide();
            $('.hab-num').hide();
            $('.panel-numerador .panel-heading b').html('Variável');
        } else {
            $('.panel-denominador').show();
            $('.hab-num').show();
            $('.panel-numerador .panel-heading b').html('Numerador');
        }
        
        $('.panel-numerador').show();
        if(value==""){
            $('.panel-numerador').hide();
            $('.panel-denominador').hide();
        }
    });
    
    $( "input[name=numerador_habilitado]:checked" ).trigger( "change" );
    $( "input[name=denominador_habilitado]:checked" ).trigger( "change" );
    $( "select[name=tipo]" ).trigger( "change" );
    $( "select[name=tipo]" ).trigger( "chosen:updated" );

});

