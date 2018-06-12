<?php

use Illuminate\Database\Seeder;

class IndicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //factory(App\Index::class,50)->create();
        $indices=[
          ['sigla'=>'ICOFAB','name'=>'Índice de Capacidade Operacional da FAB'], 
          ['sigla'=>'InCEAB','name'=>'Índice do Controle do Espaço Aéreo Brasileiro'], 
          ['sigla'=>'InGeFAB','name'=>'Índice de Gestão Administrativa da FAB'], 
          ['sigla'=>'InGeFIN','name'=>'Índice de Gestão Financeira da FAB'], 
        ];
        foreach ($indices as $index):
            \App\Index::create($index);
        endforeach;
    }
}
