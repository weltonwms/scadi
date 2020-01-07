@extends('layouts.app_interno')
@section('content_interno')

<h4>Listagem de Indicadores</h4>
<hr>

<div class="row">
    <a class="btn btn-primary pull-right" href="{{route('indicators.create')}}">Novo Indicador</a>
</div>


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

<table class="table table-striped table-condensed table-hover" id="tabela_indicadores">
    <thead>
        <tr>
            <th>ID</th>
            <th>Sigla</th>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Periodicidade</th>
            <th>Índice</th>
            <th>Grupo(s)</th>
            <th width='20%'>Ações</th>
        </tr>
    </thead>

    <tbody>



    </tbody>
</table>



@endsection

@push('scripts')
<script>
    $('select[name=periodicidade]').change(function () {
        var valor = this.value ? this.value : '';
        tabela_indicadores.column(4).search(valor).draw();

    });


    $('select[name=index]').change(function () {
        var valor = this.value ? this.value : '';
        tabela_indicadores.column(5).search(valor).draw();
    });

    $(".btn-limpar").click(function () {
        $('select[name=periodicidade]').val('');
        $('select[name=index]').val('');
        tabela_indicadores.column(4).search('');
        tabela_indicadores.column(5).search('');
        tabela_indicadores.search('').draw();
    });

    $(document).ready(function () {
        var valorSearch1 = tabela_indicadores.column(4).search();
        var valorSearch2 = tabela_indicadores.column(5).search();
        $('select[name=periodicidade]').val(valorSearch1);
        $('select[name=index]').val(valorSearch2);
    });
</script>
@endpush




