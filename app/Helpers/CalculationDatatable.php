<?php

namespace App\Helpers;

/**
 * Description of IndicatorDatatable
 *
 * @author welton
 */
use App\Indicator;

class CalculationDatatable {

    private $query;
    private $debug;

    private function start() {
        $group_id=auth()->user()->group->id; //id do grupo do usuário logado. A query total baseia-se apenas nos indicadores do grupo de usuário
        $this->query = Indicator::query();
        $this->query
                ->join('indicators_periodicidade', 'indicators.periodicidade', '=', 'indicators_periodicidade.id')
                ->join('indices', 'indicators.index_id', '=', 'indices.id')
                ->join('group_indicator', 'group_indicator.indicator_id', '=', 'indicators.id')
                ->select('indicators.id', 'indicators.sigla', 'indicators.name', 'indicators.periodicidade', 'indicators.tipo'
                        , 'indicators_periodicidade.description as periodicidade_nome'
                        , 'indices.sigla as index_sigla')
                ->where('group_indicator.group_id', $group_id);
    }

    private function pesquisa($search, $searchPeriodicidade = null, $searchIndex = null) {

        if ($search):
            $this->query->where(function($query) use ($search) { //QUERY GRUPO. Equivalente a colocar parenteses em um monte de where
                $query->where('indicators.id', '=', $search)
                        ->orWhere('indicators.sigla', 'like', "%$search%")
                        ->orWhere('indicators_periodicidade.description', 'like', "%$search%")
                        ->orWhere('indices.sigla', 'like', "%$search%");
            });
        endif;
        
        if ($searchPeriodicidade):
            $this->query->where('indicators.periodicidade', $searchPeriodicidade);

        endif;

        if ($searchIndex):
            $this->query->where('indicators.index_id', $searchIndex);
        endif;

        
        $this->debug = 'debug qualquer';
    }

    /**
     * Método de entrada da classe. 
     * @param array $req parâmetros de requisição do Datatables
     * @return string json utilizado por Datatables
     */
    public function getTable($req) {
        $this->start();
        $total = $this->query->count(); //total inicial apenas no grupo do usuário logado
        $recordsFiltered = $total;
        $this->start();

        $searchPeriodicidade = $req['columns'][3]['search']['value']; //posicao 3 pode alterar no frontend
        $searchIndex = $req['columns'][2]['search']['value']; //posicao 2 pode alterar no frontend
        if ($req['search']['value'] || $searchPeriodicidade || $searchIndex):
            $this->pesquisa($req['search']['value'], $searchPeriodicidade, $searchIndex);
            $recordsFiltered = $this->query->count(); //zera a query, por isso é necessário repetir a pesquisa
            $this->start();
            $this->pesquisa($req['search']['value'], $searchPeriodicidade, $searchIndex);
        endif;

        $order = $req['columns'][$req['order']['0']['column']]['name'];
        $direction = $req['order']['0']['dir'];
        $this->query->orderBy($order, $direction);
        $this->query->skip($req["start"])->take($req["length"]);
        $indicators = $this->query->get();

        $resposta = new \stdClass();
        $resposta->draw = $req['draw'];
        $resposta->recordsTotal = (int) $total;
        $resposta->recordsFiltered = (int) $recordsFiltered;
        $resposta->data = $this->outputList($indicators);
        $resposta->debug = $this->debug;
        return json_encode($resposta);
    }

    private function outputList($indicators) {
        foreach ($indicators as $indicator):
            $dt = $indicator->getDateLastCalculation();
            $dtLastCalc = $dt ? $dt->format('d/m/Y H:i:s') : '';
            $indicator->ultima_apuracao_data = $dtLastCalc;
            $indicator->ultima_apuracao_valor = $indicator->getValorLastCalculation();
            
            $addVal = ' <a class="btn btn-default"
                            data-toggle="tooltip"
                            title="Incluir Valor"
                            href="' . url("calculations/{$indicator->id}/create") . '">
                            Incluir Valor 
                        </a>';
            $historico = ' <btn class="btn btn-default btn-history" 
                           data-toggle="tooltip"
                           data-id="' . $indicator->id . '"
                           title="Histórico"
                            >
                            Histórico
                        </btn>';

            $indicator->acoes = $addVal . $historico;
        endforeach;
        return $indicators;
    }

}
