<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Structure\Rank;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Rank::class, function (Faker $faker) {
    $departments = DB::table('structure_departments')->count();
    return [
        'name' => $faker->jobTitle,
        'description' => $faker->text(150),
        'color' => $faker->hexcolor,
        'department_id' => $faker->numberBetween(1,$departments),
        'level' => $faker->numberBetween(1,12),
    ];
});
