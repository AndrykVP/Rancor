<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Forums\Board;
use Faker\Generator as Faker;

$factory->define(Board::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->sentence(12),
        'category_id' => rand(1,2),
        'slug' => $faker->unique()->word,
        'order' => rand(1,20),
    ];
});
