<?php

use Illuminate\Database\Seeder;

class IndicatorsTipoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types=[
          ['id'=>1,'description'=>'Relação'], 
          ['id'=>2,'description'=>'Valor Único'], 
          ['id'=>3,'description'=>'Valor Binário'] 
         
        ];
         
          \DB::table('indicators_tipo')->insert($types);
    }
}
