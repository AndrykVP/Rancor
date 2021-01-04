<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Structure\Rank;
use Faker\Generator as Faker;

$factory->define(Rank::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
        'description' => $faker->text(150),
        'color' => $faker->hexcolor,
        'department_id' => rand(1,12),
        'level' => rand(1,12),
    ];
});
