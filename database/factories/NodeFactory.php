<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Holocron\Node;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Node::class, function (Faker $faker) {
    $users = DB::table('users')->count();
    return [
        'name' => $faker->unique()->company,
        'body' => $faker->paragraph(true),
        'author_id' => $faker->numberBetween(1, $users),
        'editor_id' => $faker->numberBetween(1, $users),
        'is_published' => $faker->boolean,
        'is_private' => $faker->boolean,
        'published_at' => $faker->boolean ? now() : null,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
