<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Structure\Department;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Department::class, function (Faker $faker) {
    $factions = DB::table('structure_factions')->count();
    return [
        'name' => $faker->company,
        'description' => $faker->catchPhrase,
        'color' => $faker->hexcolor,
        'faction_id' => $faker->numberBetween(1,$factions),
    ];
});
