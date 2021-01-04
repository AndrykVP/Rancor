<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Forums\Discussion;
use Faker\Generator as Faker;

$factory->define(Discussion::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(4),
        'is_sticky' => $faker->boolean,
        'is_locked' => $faker->boolean,
        'board_id' => $faker->numberBetween(1,6),
        'author_id' => $faker->numberBetween(1,20),
    ];
});
