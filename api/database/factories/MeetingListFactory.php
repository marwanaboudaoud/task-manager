<?php

use Faker\Generator as Faker;

$factory->define(App\MeetingList::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'creator_id' => App\User::all()->random()->id,
        'is_archived' => $faker->boolean,
    ];
});
