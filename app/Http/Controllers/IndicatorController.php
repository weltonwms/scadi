<?php

namespace App\Http\Controllers;

use App\Indicator;
use App\Http\Requests\IndicatorRequest;

class IndicatorController extends Controller {

    public function __construct() {
        $this->middleware('adm');
    }

    public function index() {
       
        $dados = [
            'indices' => \App\Index::pluck('sigla', 'id')->prepend('-Selecione-', ''),
            'indicators' => Indicator::getAllByFiltro()
        ];

        return view("indicators.index", $dados);
    }

    public function create() {
        $dados = [
            'indices' => \App\Index::pluck('sigla', 'id')->prepend('-Selecione-', ''),
            'groups' => \App\Group::pluck('name', 'id'),
            'indicators' => Indicator::pluck('sigla', 'id')->prepend('-Sem pai-', '')
        ];
        return view('indicators.create', $dados);
    }

    public function store(IndicatorRequest $request) {
        $newIndicator = Indicator::create($request->all());
        $newIndicator->groups()->sync($request->groups_list);
        $newIndicator->setLevel();
        $newIndicator->save();

        if ($newIndicator->id):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionCreate')]);
        endif;
        return redirect()->route("indicators.index");
    }

    public function show(Indicator $indicator) {
        echo "show {$indicator->id}";
        
      }

    public function clonar(Indicator $indicator) {
        $groups = $indicator->groups->pluck('id');
        $new = $indicator->replicate();
        $new->save();
        $new->groups()->sync($groups);

        if ($new->id):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => 'Indicador Clonado com Sucesso!']);
        endif;
        return redirect()->route("indicators.index");
        //dd($indicator->groups);
    }

    public function edit(Indicator $indicator) {
        $dados = [
            'indices' => \App\Index::pluck('sigla', 'id')->prepend('-Selecione-', ''),
            'groups' => \App\Group::pluck('name', 'id'),
            'indicator' => $indicator,
            'indicators' => $indicator->getListFormChildren()
        ];
        return view('indicators.edit', $dados);
    }

    public function update(IndicatorRequest $request, Indicator $indicator) {
       // \App\Calculation::AtualizarCalculationsPorMudancaIndicator($request, $indicator);
        $indicator->update($request->all());
        $indicator->groups()->sync($request->groups_list);
        $indicator->setLevel();
        $retorno = $indicator->save(); //retorna true se salvar
        
        $indicator->saveLevelChildren();
        if ($retorno):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionUpdate')]);
        endif;
        return redirect()->route('indicators.index');
    }

    public function destroy(Indicator $indicator) {
        $retorno = $indicator->delete();
        if ($retorno):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionDelete')]);
        endif;
        return redirect()->route('indicators.index');
    }

}

