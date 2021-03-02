<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Structure\Type;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Type::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company,
        'description' => $faker->text(150),
    ];
});
