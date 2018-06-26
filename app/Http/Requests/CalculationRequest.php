<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculationRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    public function rules() {
       
        $indicator=$this->route('indicator');
        $n=$indicator->numerador_habilitado?'required|numeric':'';
        $d=($indicator->denominador_habilitado )?'required|numeric':'';
       
        return [
            
            'valor_numerador' => $n,
            'valor_denominador' =>$d,
        ];
    }
    
     public function messages() {
        return [
            'valor_numerador.required' => 'O campo valor é obrigatório',
            'valor_numerador.numeric'=>"O campo valor deve conter números. Utilize '.' para casas decimais",
            'valor_denominador.numeric'=>"O campo valor deve conter números. Utilize '.' para casas decimais"
          
        ];
    }

    
    

}
