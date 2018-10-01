<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogCalculation extends Model {

    public static function salvar($calculation) {
        $logSearch = LogCalculation::find($calculation->id);
        if (!$logSearch):
            $log = new LogCalculation();
            foreach ($calculation->getAttributes() as $key => $value):
                $log->$key = $value;
            endforeach;
            $log->deleted_at = date('Y-m-d H:i:s');
            $log->deletado_por = auth()->user()->id;
            return $log->save();
        endif;
    }

}
