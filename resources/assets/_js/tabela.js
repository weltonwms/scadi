/*
 * Datatable deverá ser carregada por ultimo, pois todos os eventos devem estar
 * no html primeiro para depois o datatable pega-los.
 */
$(document).ready(function() {
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

function draw(){
   //funções a chamar quando carrega table
}

