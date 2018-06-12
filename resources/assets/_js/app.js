$(document).ready(function () {
    $(".confirm").confirm({
        text: "Deseja realmente excluir este Item?",
        title: "  Exclusão de Item",
        confirmButton: " Excluir",
        cancelButton: " Cancelar",
        post: true

    });

   
    datepickerOptions = {
        format: "dd/mm/yyyy",
        language: "pt-BR",
        todayHighlight: true
    };
    $('.dateBr').datepicker(datepickerOptions);

    $("body").tooltip({
        selector: '[data-toggle="tooltip"]'
    });




    $('.telefone').mask(SPMaskBehavior, spOptions);
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
    $('.date').mask('A0/I0/0000', {'translation': {
            A: {pattern: /[0-3]/},
            I: {pattern: /[0-1]/}
        }
    });
   
    $('.meu_chosen').chosen({
        allow_single_deselect: true,
        no_results_text: "Oops, Não encontrado!"

    });



}); //fechamento do ready

var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };




