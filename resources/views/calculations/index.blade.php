@extends('layouts.app_interno')
@section('content_interno')

<h4>Apurações</h4>
<hr>
<?php
$periodos = ['' => '--Selecione--', 1 => 'Mensal', 2 => 'Semestral', 3 => 'Anual'];
?>

<br>
<table class="tabela table table-striped" id="tabela">
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
        @foreach($indicators as $indicator)
        <tr>
            <td>{{$indicator->id}}</td>
            <td>{{$indicator->sigla}}</td>
            <td>{{$indicator->index->sigla}}</td>
            <td>{{$indicator->nome_periodicidade}}</td>
            <td>
                @if($indicator->getDateLastCalculation())
                {{$indicator->getDateLastCalculation()->format('d/m/Y H:i:s')}}
                @endif
            </td>
            <td>{{$indicator->getValorLastCalculation()}}</td>

            <td class="col-md-2">
                <a class='btn btn-default' href="{{url("calculations/$indicator->id/create")}}">Incluir Valor</a>
    <btn class='btn btn-default btn-history' data-id="{{$indicator->id}}">Histórico</btn>
</td>

</tr>
@endforeach


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

<script>
    table_historico = $('#tabela-modal-historico').DataTable({
        "iDisplayLength": 10,
        "ordering": false,
        "lengthMenu": [5, 10, 25, 50],
        "dom": "<'row'<'col-sm-6'f><'col-sm-6'l>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",

        "columns": [
            {"data": "valor"},
            {"data": "data_inicio"},
            {"data": "criado_por"},
            {"data": "validado_por"},
            {"data": "atual"}
        ],
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

    $(".btn-history").click(function () {
        var id = this.dataset.id;
        table_historico.ajax.url("calculations/" + id + "/show").load();
        $('#modal-historico').modal('show');
//        $('#container').css( 'display', 'block' );
//        table_historico.columns.adjust().draw();
    });


</script>
@endpush





