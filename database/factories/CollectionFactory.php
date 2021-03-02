<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Holocron\Collection;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Collection::class, function (Faker $faker) {
    $users = DB::table('users')->count();
    return [
        'name' => $faker->unique()->company,
        'slug' => $faker->unique()->word,
        'description' => $faker->text(150),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
