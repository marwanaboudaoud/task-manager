<?php

use Faker\Generator as Faker;

$factory->define(App\Note::class, function (Faker $faker) {
    return [
        'text' => " ",
        'user_id' => App\User::all()->random()->id,
    ];
});
