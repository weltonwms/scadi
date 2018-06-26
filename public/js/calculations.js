$(document).ready(function () {
    $("#btn-repetir-lancamento").click(function () {
        var value = $("input[name=lastCalculation]").val();
        if (value) {
            var lastCalculation = JSON.parse(value);
            //console.log(lastCalculation);
            setValue("[name=valor_numerador]", lastCalculation.valor_numerador);
            setValue("input[name=valor_denominador]", lastCalculation.valor_denominador);
            setValue("input[name=obs_numerador]", lastCalculation.obs_numerador);
            setValue("input[name=obs_denominador]", lastCalculation.obs_denominador);
        } else {
            bootbox.alert({message:'Nenhum lançamento anterior encontrado!', title:"Alerta",size:'small'})
            //alert('Nenhum lançamento anterior encontrado!');
        }
    });

    $('form[name=form-calculations] input[type=submit]').click(function (event) {
        event.preventDefault(); //evitando o submit
        var retorno = validaCalculation();
        enviaForm(retorno); //enviando o formulario se o retorno for true;
        
    });


});//fim ready


function setValue(target, valor) {
   
    if (!$(target).attr('disabled')) {
        $(target).val(valor);
    }

}

function validaCalculation() {
    var valor_numerador=$('input[name=valor_numerador]').val();
    var valor_denominador=$('input[name=valor_denominador]').val();
    
    if(valor_denominador==undefined){
        return true; //não realiza validação se não tiver numerador
    }
    var vlNum = parseFloat(valor_numerador.replace(",", "."));
    var vlDen = parseFloat(valor_denominador.replace(",", "."));
    if (vlNum > vlDen) {
        confirmar();
        return false;
    }
    return true;
}


function enviaForm(submeter) {
    if (submeter) {
        $('form[name=form-calculations]').submit();
    }
}

function confirmar(){
     bootbox.confirm({
            message: "<p align='center'>Atenção! O numerador é maior que o denominador.</p> <p align='center'>Deseja continuar?</p>",
            callback: enviaForm,
            title: "Confirmação",
            
            buttons: {
                confirm: {
                    label: 'Sim',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Cancelar',
                    className: 'btn-default pull-right marginl4'
                    
                }
            }
        });
}

