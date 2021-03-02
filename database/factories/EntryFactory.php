<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Scanner\Entry;
use Faker\Generator as Faker;

$factory->define(Entry::class, function (Faker $faker) {
    $users = DB::table('users')->count();
    return [
        'entity_id' => $faker->unique->randomNumber(9),
        'type' => $faker->company,
        'name' => $faker->name,
        'owner' => $faker->name,
        'position' => [
            'galaxy' => [
                'x' => rand(0,400),
                'y' => rand(0,400)
            ],
            'system' => [
                'x' => rand(0,20),
                'y' => rand(0,20)
            ],
            'surface' => [
                'x' => rand(0,20),
                'y' => rand(0,20)
            ],
            'ground' => [
                'x' => rand(0,20),
                'y' => rand(0,20)
            ],
        ],
        'last_seen' => now(),
        'updated_by' => $faker->numberBetween(1,$users)
    ];
});
