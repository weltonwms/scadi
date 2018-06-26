$(document).ready(function () {
    /**
 * **********************************************************************
 * instrução para as requisões ajax da jquery incluir o csrf-token laravel
 *************************************************************************
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    
    $(".confirm").confirm({
        text: "Deseja realmente excluir este Item?",
        title: "  Exclusão de Item",
        confirmButton: " Excluir",
        cancelButton: " Cancelar",
        post: true

    });


    $(".confirm_aceitar").confirm({
        text: "Deseja realmente Aceitar este Item?",
        title: "  Aceitação de Item",
        confirmButton: " Confirmar",
        cancelButton: " Cancelar",
        post: true,
        method: 'put',
        classConfirmButton: "btn btn-primary",
        classIconConfirmButton: "glyphicon glyphicon-ok",

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
        no_results_text: "Oops, Não encontrado!",
        search_contains: true

    });
    
    $(".btn-limpar").click(function(){
       $("#tabela").DataTable().search("").draw()
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





/*
 * Datatable deverá ser carregada por ultimo, pois todos os eventos devem estar
 * no html primeiro para depois o datatable pega-los.
 */
$(document).ready(function () {
    $('.tabela').dataTable({
        "dom": "<'row'<'col-sm-6'f><'col-sm-6'l>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "iDisplayLength": 10,
        "bStateSave": true,
        "columnDefs": [{
                "targets": [-1],
                "orderable": false
            }],
        "autoWidth": false,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "<span class='text-danger'>Mostrando 0 / 0 de 0 registros</span>",
            "sInfoFiltered": "<span class='text-danger'>(filtrado de _MAX_ registros)</span>",
            "sSearch": "<span class='glyphicon glyphicon-search'></span> Pesquisar: ",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        drawCallback: draw
    }); //funções a chamar quando carrega table




}); //fechamento do ready

function draw() {
    //funções a chamar quando carrega table
}

// ---------------------------------------------------------- Generic Check All  

$(".check_all").click(function () {
    var checar = $(this).is(":checked");
    $(".checados").prop("checked", checar);

});

$(".checados").click(function () {
    if (!$(this).is(":checked") && $('.check_all').is(":checked")) {
        $('.check_all').prop("checked", false);
    }
});


