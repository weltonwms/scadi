<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
     protected $fillable=['description','name'];
     
     
      public function indicators(){
        return $this->belongsToMany("App\Indicator");
    }
    
    
    public function verifyAndDelete() {
        //Vericando se o grupo está associado a usuário
        $values= \App\User::where('group_id', $this->id)->get();
        if($values->isNotEmpty()):
           \Session::flash('mensagem', ['type' => 'danger', 'conteudo' => 'Existe Usuário Relacionado a esse Grupo!']);
            return false;
        endif;
      
        return $this->delete();
    }
}
