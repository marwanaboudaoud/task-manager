<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'title' => encrypt($faker->title),
        'description' => encrypt($faker->text),
        'deadline' => $faker->dateTimeThisMonth,
        'user_id' => App\User::all()->random()->id,
        'category_id' => App\Category::all()->random()->id,
        'is_completed' => $faker->boolean,
    ];
});
