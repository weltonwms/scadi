<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'om' => $faker->word,
        'adm' => 0,
        'guerra' => $faker->firstName,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Index::class, function (Faker\Generator $faker) {
    return [
        'sigla' => $faker->word,
        'descricao' => $faker->sentence(6,true),
       
    ];
});

$factory->define(App\Indicator::class, function (Faker\Generator $faker) {
    return [
        'sigla' => $faker->word,
        'descricao' => $faker->sentence(6,true),
        'unidade_medida' => $faker->word,
        'mensuracao' => $faker->word,
        'periodicidade' => $faker->numberBetween(1, 4),
        'index_id'=> \App\Index::all()->random()->id,
       
    ];
});


