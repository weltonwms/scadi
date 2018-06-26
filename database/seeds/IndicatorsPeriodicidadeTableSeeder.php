<?php

use Illuminate\Database\Seeder;

class IndicatorsPeriodicidadeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
    {
         $types=[
          ['id'=>1,'description'=>'Mensal'], 
          ['id'=>2,'description'=>'Semestral'], 
          ['id'=>3,'description'=>'Anual'], 
          ['id'=>4,'description'=>'Trimestral'],
          ['id'=>5,'description'=>'Bimestral'],
        ];
         
          \DB::table('indicators_periodicidade')->insert($types);

    }
}
