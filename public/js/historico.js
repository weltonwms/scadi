$(document).ready(function () {

    $("#btn-valida-apuracoes").click(function (event) {
        event.preventDefault();

        var checados = $('.checados:checked');
        if (checados.length < 1) {
            //alert('Primeiro faça uma seleção na lista!');
            bootbox.alert({message:'Primeiro faça uma seleção na lista!',title:"Alerta",size:'small'});
        } else {
            var msg="Confirma a Validação de "+checados.length+" registro(s)?";
            var form="form[name=form-apuracoes]";
            confirmarSubmit(msg,form);
//            $("#nr_pendencias").html(checados.length);
//            $('#modal_lancar_pendencias').modal('show');
        }
    });
    
    $("#btn-filter-buscar").click(function (event) {
        var tipo= parseInt($('select[name=periodo_tipo]').val());
        var ano= parseInt($('select[name=periodo_ano]').val());
        if(tipo>=0 && !ano){
            bootbox.alert({message:'Necessário Selecionar Ano para o Período!',title:"Alerta",size:'small'});
            event.preventDefault();
        }
        
     });



});// fechamento do ready



function confirmarSubmit(msg, form) {
    
    bootbox.confirm({
        message: msg,
        callback: function (result) {
            if (result) {
               $(form).submit();
            }
        },
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



