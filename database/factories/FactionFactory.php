<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Faction\Faction;
use Faker\Generator as Faker;

$factory->define(Faction::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
    ];
});
