<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Index extends Model
{
    protected $fillable=['sigla','description','name'];
    
    
    public function indicators(){
        return $this->hasMany("App\Indicator");
    }
    
    
   public function verifyAndDelete()
   {
       if($this->indicators->isEmpty()):
            return $this->delete();
       else:
            \Session::flash('mensagem', ['type' => 'danger', 'conteudo' => trans('Existe(m) Indicador(es) relacionado(s)')]);
            return false;
       endif;
   }
   
   
   
}
