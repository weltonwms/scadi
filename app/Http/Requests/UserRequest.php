<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user=$this->route('user'); //route disponível em edição
        $id=$user?$user->id:null; //usado para permitir edição
        $campos= [
            'username'=>"required|max:255|unique:users,username,$id",
            'guerra'=>"required|max:255",
            'name'=>"required|max:255"
        ];
        if(auth()->user()->isAdm):
            $campos['perfil']="required|max:255";
            $campos['group_id']="required";
        endif;
        return $campos;
    }
    
    public function messages() {
        return [
            'name.required' => 'O campo nome é obrigatório',
             'guerra.required' => 'O campo nome de Guerra é obrigatório',
            'group_id.required'=>"O campo Grupo é obrigatório"
        ];
    }
}
