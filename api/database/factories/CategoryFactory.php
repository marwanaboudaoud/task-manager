<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    $name = $faker->name;
    $meetingListId = App\MeetingList::all()->random()->id;
    return [

        'name' => $name,
        'meeting_list_id' => $meetingListId,
        'slug' => strtolower(str_replace(' ', '-',$meetingListId . "-" . $name)),
    ];
});
