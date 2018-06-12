<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calculation;
use App\User;
use App\Indicator;
//use Carbon\Carbon;

class HistoricController extends Controller {

    public function __construct() {
       $this->middleware('history');
    }

    public function index() {
       
        $dados = [
            'calculations' => Calculation::getByFiltro(),
            'indicators' => Indicator::pluck('sigla', 'id')->prepend('--Selecione--', ''),
            'users' => User::pluck('name', 'id')->prepend('--Selecione--', ''),
        ];
        //dd($dados['calculations']);
       
         
        return view("historics.index", $dados);
    }

    public function validar(Request $request) {
       // dd($request->validar);
        $retorno= Calculation::validar($request->validar);
         if ($retorno):
            \Session::flash('mensagem', ['type' => 'success', 'conteudo' => "$retorno registro(s) validado(s)!"]);
        endif;
        return redirect()->back();
    }

    

}
