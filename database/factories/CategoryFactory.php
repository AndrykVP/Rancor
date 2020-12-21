<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Forums\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'title' => $faker->company,
        'color' => $faker->hexcolor,
        'slug' => $faker->unique()->word,
        'order' => $faker->unique()->numberBetween(1,20),
    ];
});
