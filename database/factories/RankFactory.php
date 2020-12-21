<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Faction\Rank;
use Faker\Generator as Faker;

$factory->define(Rank::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
        'description' => $faker->text(150),
        'department_id' => rand(1,12),
        'level' => rand(1,12),
    ];
});
