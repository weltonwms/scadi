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
        $mes_atual = (int) date('m');
        if ($mes_atual > 6) {
            return 2;
        }
        return 1;
    }

    public static function getTrimestreAtual() {
        $mes_atual = (int) date('m');
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
        $mes_atual = (int) date('m');
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

}
