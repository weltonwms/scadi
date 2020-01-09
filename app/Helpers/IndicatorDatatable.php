<?php

namespace App\Helpers;

/**
 * Description of IndicatorDatatable
 *
 * @author welton
 */
use App\Indicator;

class IndicatorDatatable {

    private $query;
    private $debug;

    private function start() {
        $this->query = Indicator::query();
        $this->query
                ->join('indicators_tipo', 'indicators.tipo', '=', 'indicators_tipo.id')
                ->join('indicators_periodicidade', 'indicators.periodicidade', '=', 'indicators_periodicidade.id')
                ->join('indices', 'indicators.index_id', '=', 'indices.id')
                ->leftJoin('group_indicator', 'group_indicator.indicator_id', '=', 'indicators.id')
                ->leftJoin('groups', 'group_indicator.group_id', '=', 'groups.id')
                ->select('indicators.id', 'indicators.sigla', 'indicators.name'
                        , 'indicators_tipo.description as tipo_nome', 'indicators_periodicidade.description as periodicidade_nome'
                        , 'indices.sigla as index_sigla' 
                        ,\DB::raw("group_concat(groups.name separator ' | ') as grupos_lista") )
                ->groupBy('indicators.id', 'indicators.sigla', 'indicators.name', 'indicators_tipo.description', 'indicators_periodicidade.description', 'indices.sigla');
    }

    private function pesquisa($search, $searchPeriodicidade = null, $searchIndex = null) {

        if ($search):
            $this->query->where(function($query) use ($search) {
                $query->where('indicators.id', '=', "$search")
                        ->orWhere('indicators.sigla', 'like', "%$search%")
                        ->orWhere('indicators.name', 'like', "%$search%")
                        ->orWhere('indicators_tipo.description', 'like', "%$search%")
                        ->orWhere('indicators_periodicidade.description', 'like', "%$search%")
                        ->orWhere('indices.sigla', 'like', "%$search%")
                        ->orWhere('groups.name', 'like', "%$search%");
            });
        endif;

        if ($searchPeriodicidade):
            $this->query->where('indicators.periodicidade', $searchPeriodicidade);

        endif;

        if ($searchIndex):
            $this->query->where('indicators.index_id', $searchIndex);
        endif;
        //$this->debug = 'debug qualquer';
    }

    /**
     * Método de entrada da classe. 
     * @param array $req parâmetros de requisição do Datatables
     * @return string json utilizado por Datatables
     */
    public function getTable($req) {
       
        $total = \DB::table('indicators')->count();
        $recordsFiltered = $total;
        $this->start();
        $searchPeriodicidade = $req['columns'][4]['search']['value']; //posicao 4 pode alterar no frontend
        $searchIndex = $req['columns'][5]['search']['value']; //posicao 5 pode alterar no frontend

        if ($req['search']['value'] || $searchPeriodicidade || $searchIndex):
            $this->pesquisa($req['search']['value'], $searchPeriodicidade, $searchIndex);
            $recordsFiltered =$this->query->get()->count(); //zera a query, por isso é necessário repetir a pesquisa
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
            //$indicator->grupos_lista = $indicator->getGroupsList();
            $clonar = ' <a class="btn btn-default"
                            data-toggle="tooltip"
                            title="Clonar"
                            href="' . url("indicators/{$indicator->id}/clonar") . '">
                            Clonar 
                        </a>';
            $edit = ' <a class="btn btn-default"
                            data-toggle="tooltip"
                            title="Editar"
                            href="' . url("indicators/{$indicator->id}/edit") . '">
                            Editar 
                        </a>';
            $delete = ' <a class="btn btn-danger confirm" 
                           data-toggle="tooltip"
                           data-info="' . $indicator->sigla . '"
                           title="Excluir"
                            href="' . url("indicators/" . $indicator->id) . '">
                            Excluir
                        </a>';
            $indicator->acoes = $clonar . $edit . $delete;
        endforeach;
        return $indicators;
    }

}
