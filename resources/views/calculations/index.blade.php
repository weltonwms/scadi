@extends('layouts.app_interno')
@section('content_interno')

<h4>Apurações</h4>
<hr>
<?php
$periodos = ['' => '--Selecione--', 1 => 'Mensal', 5 => 'Bimestral', 4 => 'Trimestral', 2 => 'Semestral', 3 => 'Anual'];
?>
<div class="row filters">
    <form class="form-inline">
        <?php $attr = ['class' => 'form-control input-sm'] ?>

        <div class="form-group">
            <label for="">Periodicidade</label>

            {!!Form::select('periodicidade', $periodos, null,$attr )!!}
        </div>
        <div class="form-group">
            <label for="">Indice</label>

            {!!Form::select('index', $indices, null,$attr )!!}
        </div>
        <div class="form-group">
            <btn class="btn btn-default btn-limpar" >Limpar</btn>
        </div>



    </form>
</div>


<br>
<table class="table table-striped" id="tabela_apuracao">
    <thead>
        <tr>
            <th>ID</th>
            <th>Indicador</th>
            <th>Índice Relacionado</th>
            <th>Periodicidade</th>
            <th>Última Apuração Dt</th>
            <th>Última Apuração Valor</th>
            <th style="padding: 0 80px">Ações</th>


        </tr>
    </thead>

    <tbody>



    </tbody>
    
</table>
<!--inicio do modal-historico-->
<div class="modal fade" tabindex="-1"  id="modal-historico" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Histórico da Apuração</h4>
            </div>
            <div class="modal-body">
                <table id="tabela-modal-historico" class="table table-condensed table-bordered" style="width:100%">
                    <thead>
                        <tr  class="success">
                            <th>Valor</th>
                            <th>Período de Referência</th>
                            <th>Criado por</th>
                            <th>Validado por</th>
                            <th>Atual</th>
                            @if(auth()->user()->isAdm)
                            <th></th>
                            @endif

                        </tr>

                    </thead>

                    <tbody>


                    </tbody>

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--fim do modal-historico-->



@endsection

@push('scripts')
<script src="{{asset("/js/bootbox.min.js")}}"></script>
<script>
  tabela_apuracao = $('#tabela_apuracao').DataTable({
        dom: "<'row'<'col-sm-6'f><'col-sm-6'l>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        iDisplayLength: 10,
        serverSide: true,
        ajax: "ajax/calculationTable",
        columns: [
            {data: "id", name: "id"},
            {data: "sigla", name: "sigla"},
            {data: "index_sigla", name: "index_sigla"},
            {data: "periodicidade_nome", name: "periodicidade_nome"},
            {data: "ultima_apuracao_data", name: "ultima_apuracao_data"},
            {data: "ultima_apuracao_valor", name: "ultima_apuracao_valor"},
            {data: "acoes"}
        ],
        "order": [0, 'desc'],
        drawCallback: ativacoesTabelaApuracao,
        "bStateSave": true,
        "columnDefs": [{
                "targets": [-1, -2, -3],
                "orderable": false
            }],
        processing: true,
        autoWidth: false,
        oLanguage: {

            'sProcessing': "<div id='loader'>Carregando...</div>",
            "sSearch": "<span class='glyphicon glyphicon-search'></span> Pesquisar: ",
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "<span class='text-danger'>Mostrando 0 / 0 de 0 registros</span>",
            "sInfoFiltered": "<span class='text-danger'>(filtrado de _MAX_ registros)</span>",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        }

    });  
    
    
    
    
table_historico = $('#tabela-modal-historico').DataTable({
    "iDisplayLength": 10,
    "ordering": false,
    "lengthMenu": [5, 10, 25, 50],
    "dom": "<'row'<'col-sm-6'f><'col-sm-6'l>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",

    "columns": getColumnsTableHistorico(),
    "autoWidth": false,
    processing: true,
    oLanguage: {
        'sProcessing': "<div id='loader'>Carregando...</div>",
        "sSearch": "<span class='glyphicon glyphicon-search'></span> Pesquisar: ",
        "sLengthMenu": "Mostrar _MENU_ registros por página",
        "sZeroRecords": "Nenhum registro encontrado",
        "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
        "sInfoEmpty": "<span class='text-danger'>Mostrando 0 / 0 de 0 registros</span>",
        "sInfoFiltered": "<span class='text-danger'>(filtrado de _MAX_ registros)</span>",
        "oPaginate": {
            "sFirst": "Início",
            "sPrevious": "Anterior",
            "sNext": "Próximo",
            "sLast": "Último"
        }
    }

});//fim table_ajax



function excluirCalculation(href) {

    $.ajax({
        url: href,
        method: 'delete',
        success: function (data) {
            console.log(data);
            table_historico.ajax.reload(null, false);
        }
    });
}

function ConfirmExcluirCalculation(event) {
    event.preventDefault();
    var alvo = event.target; //ṕode ser o span ou o link
    var href = $(alvo).closest('a').attr('href'); //procura pelo href no link
    bootbox.confirm({
        message: "Deseja realmente excluir este valor?",
        callback: function (result) {
            if (result) {
                excluirCalculation(href);
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


function getColumnsTableHistorico() {
    var columns = [
        {"data": "valor"},
        {"data": "data_inicio"},
        {"data": "criado_por"},
        {"data": "validado_por"},
        {"data": "atual"}
    ];

<?php if (auth()->user()->isAdm): ?>
        columns.push({data: null, render: function (data, type, row) {

                var url = 'calculations/' + data.id;
                var link = '<a href="' + url + '" onclick="ConfirmExcluirCalculation(event)"><span class="text-danger glyphicon glyphicon-trash"></span></a>';
                return link;
            }
        });
<?php endif ?>

    return columns;


}


function ativacoesTabelaApuracao(){
    $(".btn-history").click(function () {
    var id = this.dataset.id;
    table_historico.ajax.url("calculations/" + id + "/show").load();
    $('#modal-historico').modal('show');

});
}


 $('select[name=periodicidade]').change(function () {
        var valor = this.value ? this.value : '';
        tabela_apuracao.column(3).search(valor).draw();

    });


    $('select[name=index]').change(function () {
        var valor = this.value ? this.value : '';
        tabela_apuracao.column(2).search(valor).draw();
    });

    $(".btn-limpar").click(function () {
        $('select[name=periodicidade]').val('');
        $('select[name=index]').val('');
        tabela_apuracao.column(3).search('');
        tabela_apuracao.column(2).search('');
        tabela_apuracao.search('').draw();
    });

    $(document).ready(function () {
        var valorSearch1 = tabela_apuracao.column(3).search();
        var valorSearch2 = tabela_apuracao.column(2).search();
        $('select[name=periodicidade]').val(valorSearch1);
        $('select[name=index]').val(valorSearch2);
    });


</script>
@endpush





