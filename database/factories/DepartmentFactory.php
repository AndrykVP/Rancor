<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Faction\Department;
use Faker\Generator as Faker;

$factory->define(Department::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->catchPhrase,
        'faction_id' => rand(1,5),
    ];
});
