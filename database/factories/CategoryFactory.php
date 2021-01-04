<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Forums\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->sentence(12),
        'color' => $faker->hexcolor,
        'slug' => $faker->unique()->word,
        'order' => $faker->unique()->numberBetween(1,20),
    ];
});
