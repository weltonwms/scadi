<?php

namespace App\Helpers;

use Carbon\Carbon;

class CalculationDate {

    public static function getAnos() {
        $year = (int) date('Y');
        $back = 10;
        $forward = 10;
        $anos = array();
        for ($i = $year - $back; $i < $year + $forward; $i++) {
            $anos[$i] = $i;
        }
        return $anos;
    }

    public static function getAnosUsados() {
        $query = \DB::table('calculations')
                ->select(\DB::raw('YEAR(`data_inicio`) as ano'))
                ->distinct()
                ->get();
        return $query->pluck('ano', 'ano');
    }

    public static function getTodosPeriodos() {
        $periodos = array_merge(self::getMeses(), self::getBimestres(), self::getTrimestres(), self::getSemestres());
        return collect($periodos);
    }

    /**
     * O método getPeriodoFromTodosPeriodos() retorna um stdClass com inicio e fim de um período.
     * Para informar um período o método recebe um código do tipo de período: Janeiro, fevereiro, 1º Bim, etc.
     * Recebe também o ano.
     * @param int $periodo_tipo código referente à chave do array de CalculationDate::getTodosPeriodos
     * @param int $periodo_ano ano do período
     * @return sdtClass  Objeto com atributos Carbon: inicio e final, referente ao período.
     */
    public static function getPeriodoFromTodosPeriodos($periodo_tipo, $periodo_ano) {
        $periodo = new \stdClass();
        if ($periodo_tipo < 12)://meses
            $periodo = self::auxMeses($periodo_tipo, $periodo_ano);
        elseif ($periodo_tipo < 18): //bimestres
            $periodo = self::auxBimestres($periodo_tipo, $periodo_ano);
        elseif ($periodo_tipo < 22): //trimestres
            $periodo = self::auxTrimestres($periodo_tipo, $periodo_ano);
        elseif ($periodo_tipo < 24): //semestres
            $periodo = self::auxSemestres($periodo_tipo, $periodo_ano);

        endif;
        return $periodo;
    }

    public static function getSemestres() {
        $semestres = [1 => "1º Semestre", 2 => "2º Semestre"];
        return $semestres;
    }

    public static function getTrimestres() {
        $trimestres = [1 => "1º Trimestre", 2 => "2º Trimestre", 3 => "3º Trimestre", 4 => "4º Trimestre"];
        return $trimestres;
    }

    public static function getBimestres() {
        $bimestres = [1 => "1º Bimestre", 2 => "2º Bimestre", 3 => "3º Bimestre", 4 => "4º Bimestre", 5 => "5º Bimestre", 6 => "6º Bimestre"];
        return $bimestres;
    }

    public static function getMeses() {
        $meses = ['', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto',
            'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];
        unset($meses[0]);
        return $meses;
    }

    public static function getSemestreAtual() {
        $mes_atual = self::getMesAtual();

        if ($mes_atual > 6) {
            return 2;
        }
        return 1;
    }

    public static function getTrimestreAtual() {
        $mes_atual = self::getMesAtual();

        if ($mes_atual < 4) {
            return 1;
        } elseif ($mes_atual < 7) {
            return 2;
        } elseif ($mes_atual < 10) {
            return 3;
        } else {
            return 4;
        }
    }

    public static function getBimestreAtual() {
        $mes_atual = self::getMesAtual();

        if ($mes_atual < 3) {
            return 1;
        } elseif ($mes_atual < 5) {
            return 2;
        } elseif ($mes_atual < 7) {
            return 3;
        } elseif ($mes_atual < 9) {
            return 4;
        } elseif ($mes_atual < 11) {
            return 5;
        } else {
            return 6;
        }
    }

    public static function getAnoAtual() {
        $date = self::getDate();
        return $date->year;
    }

    public static function getMesAtual() {
        $date = self::getDate();
        return $date->month;
    }

    public static function getDate() {
        $date = Carbon::now();
        //$date=Carbon::createFromFormat('Y-m-d', '2018-01-01'); //teste
        $date->month = $date->month - 1; //cálculo de data em cima do mês anterior
        return $date;
    }

    /**
     * Retorna Uma Data de Inicio, baseada na periodicidade: mensal, semestral ou anual
     * 
     * @param array $request
     * @param App\Indicator $indicator
     * @return Carbon data de ínicio
     */
    public static function getDataInicio($request, $indicator) {
        $dia = 1;
        $mes = 0;
        $ano = $request['data_ano'];
        if ($indicator->periodicidade == 1):
            $mes = $request['data_mes'];
        endif;

        if ($indicator->periodicidade == 2):
            if ($request['data_semestre'] == 1) {
                $mes = 1;
            } else {
                $mes = 7;
            }
        endif;

        if ($indicator->periodicidade == 3):
            $mes = 1;
        endif;


        if ($indicator->periodicidade == 4):
            if ($request['data_trimestre'] == 1) {
                $mes = 1;
            } elseif ($request['data_trimestre'] == 2) {
                $mes = 4;
            } elseif ($request['data_trimestre'] == 3) {
                $mes = 7;
            } elseif ($request['data_trimestre'] == 4) {
                $mes = 10;
            }
        endif;

        if ($indicator->periodicidade == 5):
            if ($request['data_bimestre'] == 1) {
                $mes = 1;
            } elseif ($request['data_bimestre'] == 2) {
                $mes = 3;
            } elseif ($request['data_bimestre'] == 3) {
                $mes = 5;
            } elseif ($request['data_bimestre'] == 4) {
                $mes = 7;
            } elseif ($request['data_bimestre'] == 5) {
                $mes = 9; //erro se colocar 09; não sei porque
            } elseif ($request['data_bimestre'] == 6) {
                $mes = 11;
            }
        endif;
        $data_inicio = Carbon::create($ano, $mes, $dia, 0, 0, 0);
        return $data_inicio;
    }
    
    /**
     * Calcula uma data final a partir de uma de ìnicio, de acordo com a periodicidade
     * do Indicador;
     * @param Carbon $data_inicio
     * @param App\Indicator $indicator
     * @return Carbon data final
     */
     public static function getDataFinal($data_inicio, $indicator) {
        //indicators_type: 1=Mensal, 2=Semestral, 3=Anual, 4=Trimestral, 5=Bimestral
        //chaves são indicators_periodicidade e valores do array é o número a ser somado no mes da data_inicio;
        $periodos = [1 => 0, 2 => 5, 3 => 11, 4 => 2, 5 => 1];
        if (isset($periodos[$indicator->periodicidade])):
            $data_final = clone $data_inicio;
            $data_final->month += $periodos[$indicator->periodicidade];
            $data_final->endOfMonth();
            return $data_final;
        endif;
    }

    public static function changeDataInicioToPeriodo($dataInicio, $periodicidade) {

        $meses = ['', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto',
            'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];
        $semestres = [1 => "1º Semestre", 2 => "2º Semestre"];
        $trimestres = [1 => "1º Trimestre", 2 => "2º Trimestre", 3 => "3º Trimestre", 4 => "4º Trimestre"];
        $bimestres = [1 => "1º Bimestre", 2 => "2º Bimestre", 3 => "3º Bimestre", 4 => "4º Bimestre", 5 => "5º Bimestre", 6 => "6º Bimestre"];

        if ($periodicidade == 1): //mensal
            $mes = $dataInicio->month;
            return $meses[$mes] . "/" . $dataInicio->year;
        endif;
        if ($periodicidade == 2): //semestral
            if ($dataInicio->month > 6) {
                return $semestres[2] . "/" . $dataInicio->year;
            } else {
                return $semestres[1] . "/" . $dataInicio->year;
            }
        endif;
        if ($periodicidade == 3): //anual
            return $dataInicio->year;
        endif;

        if ($periodicidade == 4): //trimestral
            if ($dataInicio->month < 4) {
                return $trimestres[1] . "/" . $dataInicio->year;
            } elseif ($dataInicio->month < 7) {
                return $trimestres[2] . "/" . $dataInicio->year;
            } elseif ($dataInicio->month < 10) {
                return $trimestres[3] . "/" . $dataInicio->year;
            } else {
                return $trimestres[4] . "/" . $dataInicio->year;
            }
        endif;

        if ($periodicidade == 5): //bimestral
            if ($dataInicio->month < 3) {
                return $bimestres[1] . "/" . $dataInicio->year;
            } elseif ($dataInicio->month < 5) {
                return $bimestres[2] . "/" . $dataInicio->year;
            } elseif ($dataInicio->month < 7) {
                return $bimestres[3] . "/" . $dataInicio->year;
            } elseif ($dataInicio->month < 9) {
                return $bimestres[4] . "/" . $dataInicio->year;
            } elseif ($dataInicio->month < 11) {
                return $bimestres[5] . "/" . $dataInicio->year;
            } else {
                return $bimestres[6] . "/" . $dataInicio->year;
            }
        endif;
    }

    /*
     * métodos auxiliares de getPeriodoFromTodosPeriodos()
     */

    private static function auxMeses($periodo_tipo, $periodo_ano) {
        $dia = 1;
        $mes = $periodo_tipo + 1;
        $ano = $periodo_ano;

        $obj = new \stdClass();
        $obj->inicio = Carbon::create($ano, $mes, $dia, 0, 0, 0);
        $obj->final = Carbon::create($ano, $mes, $dia, 0, 0, 0);
        $obj->final->endOfMonth();
        return $obj;
    }

    private static function auxBimestres($periodo_tipo, $periodo_ano) {
        $bimestres = [12 => 1, 13 => 3, 14 => 5, 15 => 7, 16 => 9, 17 => 11];
        $dia = 1;
        $mes = $bimestres[$periodo_tipo];
        $ano = $periodo_ano;
        $obj = new \stdClass();
        $obj->inicio = Carbon::create($ano, $mes, $dia, 0, 0, 0);
        $obj->final = Carbon::create($ano, $mes, $dia, 0, 0, 0);
        $obj->final->month++;
        $obj->final->endOfMonth();
        return $obj;
    }

    private static function auxTrimestres($periodo_tipo, $periodo_ano) {
        $trimestres = [18 => 1, 19 => 4, 20 => 7, 21 => 10];
        $dia = 1;
        $mes = $trimestres[$periodo_tipo];
        $ano = $periodo_ano;
        $obj = new \stdClass();
        $obj->inicio = Carbon::create($ano, $mes, $dia, 0, 0, 0);
        $obj->final = Carbon::create($ano, $mes, $dia, 0, 0, 0);
        $obj->final->month += 2;
        $obj->final->endOfMonth();
        return $obj;
    }

    private static function auxSemestres($periodo_tipo, $periodo_ano) {
        $semestres = [22 => 1, 23 => 7];
        $dia = 1;
        $mes = $semestres[$periodo_tipo];
        $ano = $periodo_ano;
        $obj = new \stdClass();
        $obj->inicio = Carbon::create($ano, $mes, $dia, 0, 0, 0);
        $obj->final = Carbon::create($ano, $mes, $dia, 0, 0, 0);
        $obj->final->month += 5;
        $obj->final->endOfMonth();
        return $obj;
    }

    /*
     * Fim métodos auxiliares de getPeriodoFromTodosPeriodos()
     */
}
