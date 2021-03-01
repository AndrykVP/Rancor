<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Forums\Board;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Board::class, function (Faker $faker) {
    $categories = DB::table('forum_categories')->count();
    return [
        'name' => $faker->company,
        'description' => $faker->sentence(12),
        'category_id' => $faker->numberBetween(1,$categories),
        'slug' => $faker->unique()->word,
        'order' => rand(1,20),
    ];
});
