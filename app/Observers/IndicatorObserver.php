<?php

namespace App\Observers;

use App\Indicator;

class IndicatorObserver {

    public function updated(Indicator $indicator) {
        //echo "observando updated";
       //dd($indicator);
    }

}
