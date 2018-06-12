<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //perfil: 1= administrator, 2= Apurador
        DB::table('users')->insert([
            'username' => "root",
            'name' => "root",
            'guerra' => "root",
            'perfil'=>1,
            'om'=>'CCA-BR',
            'password' => bcrypt('123456'),
        ]);
    }
}
