<?php

use Illuminate\Database\Seeder;

class IndicatorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         factory(App\Indicator::class,50)->create();
    }
}
