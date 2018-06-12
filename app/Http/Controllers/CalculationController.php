<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests\CalculationRequest;
use App\Calculation;
use App\Indicator;
use App\Index;

class CalculationController extends Controller {

    public function __construct() {

        $this->middleware('calculation')->except('index');
    }

    public function index() {

//       dd(Indicator::getPermitidos(request()) );

        $dados = [
            'indicators' => Indicator::getPermitidos(request()),
            'indices' => Index::pluck('sigla', 'id')->prepend('--Selecione--', ''),
            'indicatorsList' => Indicator::getPermitidos()->pluck('sigla', 'id')->prepend('--Selecione--', '')
        ];


        return view('calculations.index', $dados);
    }

    public function create(Indicator $indicator) {
        // dd($indicator->getDateLastCalculation());

        $dados = [
            'indicator' => $indicator
        ];
        return view('calculations.create', $dados);
    }

    public function store(CalculationRequest $request, Indicator $indicator) {
       
        $dados = $this->trataDados($request, $indicator);
        Calculation::zerarCalculationsRepetidos($dados);
        $newCalculation = Calculation::create($dados);
        if ($newCalculation->id):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => trans('messages.actionCreate')]);
        endif;
        return redirect()->route("calculations.index");
    }

    public function showHistory(Indicator $indicator) {
        $dados = [];
        $dados['data']=[];
        foreach ($indicator->calculations->sortByDesc('created_at') as $calculation):
            $obj = new \stdClass();
            $obj->valor = $calculation->getValor();
            $obj->criado_por = $calculation->getCriadoPor();
            $obj->validado_por = $calculation->getValidadoPor();
            $obj->data_inicio= $calculation->getPeriodoReferencia();
            $obj->atual= $calculation->getAtual();
            $dados['data'][] = $obj;
        endforeach;
        return $dados;
    }

    private function trataDados($request, $indicator) {
        $dados = $request->all();
        $dados['data_inicio'] = \App\Helpers\CalculationDate::getDataInicio($dados, $indicator);
        $dados['indicator_id'] = $indicator->id;
        $dados['user_id'] = auth()->user()->id;
        $dados['atual']=1; //indicação de que o registro é o último; analisar essa responsabilidade para o model

        if (!$indicator->numerador_habilitado):
            $dados['valor_numerador'] = $indicator->numerador_valor_padrao;
            $dados['obs_numerador'] = 'Valor Padrão';
        endif;

        if (!$indicator->denominador_habilitado):
            $dados['valor_denominador'] = $indicator->denominador_valor_padrao;
            $dados['obs_denominador'] = 'Valor Padrão';
        endif;
        
        if($indicator->tipo==2 || $indicator->tipo==3):
             $dados['valor_denominador']=1; //garantir que sempre o denominador é 1 para único e binário
            $dados['obs_denominador'] = $indicator->nome_tipo;
        endif;
            
        

        return $dados;
    }

}
