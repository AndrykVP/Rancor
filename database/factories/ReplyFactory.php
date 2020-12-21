<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Forums\Reply;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'discussion_id' => $faker->numberBetween(1,30),
        'author_id' => $faker->numberBetween(1,20),
        'body' => $faker->paragraph(true),
    ];
});
