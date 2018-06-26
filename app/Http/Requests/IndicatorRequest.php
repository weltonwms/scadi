<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndicatorRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        $this->tratarDados();
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {


        $nv = $this->numerador_habilitado ? '' : 'required|numeric';
        $dv = $this->denominador_habilitado ? '' : 'required|numeric';
        $d = $this->tipo == 1 ? 'required' : '';

        //dd($this->all());
        return [
            'tipo' => "required",
            'sigla' => "required",
            'description' => "required",
            'name' => "required",
            'peso' => 'required|numeric|between:0,1',
            'numerador_name' => "required",
            'numerador_sigla' => "required",
            'denominador_name' => $d,
            'denominador_sigla' => $d,
            'periodicidade' => "required",
            'index_id' => "required",
            'numerador_valor_padrao' => $nv,
            'denominador_valor_padrao' => $dv,
        ];
    }

    public function messages() {
        return [
            'index_id.required' => 'O campo índice é obrigatório',
            'description.required' => 'O campo descrição é obrigatório',
            'numerador_name.required' => 'O campo Nome é obrigatório',
            'numerador_sigla.required' => 'O campo Sigla é obrigatório',
            'denominador_name.required' => 'O campo Nome é obrigatório',
            'denominador_sigla.required' => 'O campo Sigla é obrigatório',
            'peso.numeric'=>"O campo peso deve conter números. Utilize '.' para casas decimais"
        ];
    }

    private function tratarDados() {
        if ($this->numerador_habilitado) {
            $this->merge(['numerador_valor_padrao' => null]);
            $this->merge(['numerador_obs_padrao' => null]);
        }

        if ($this->denominador_habilitado) {
            $this->merge(['denominador_valor_padrao' => null]);
            $this->merge(['denominador_obs_padrao' => null]);
        }

        if ($this->tipo != 1) {
            //se tipo for unico ou binario
            //desabilitar denominador, habilitar sempre o numerador
            $this->merge(
                    [
                        'denominador_habilitado'=>0,
                        'denominador_name' => null,
                        'denominador_sigla' => null,
                        'denominador_description' => null,
                        'denominador_obs_padrao' => null,
                        'denominador_valor_padrao' => 1,
                        'numerador_habilitado' => 1,
                    ]
            );
        }
    }

}
