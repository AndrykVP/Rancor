<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Forums\Discussion;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Discussion::class, function (Faker $faker) {
    $boards = DB::table('forum_boards')->count();
    $users = DB::table('users')->count();
    return [
        'name' => $faker->sentence(4),
        'is_sticky' => $faker->boolean,
        'is_locked' => $faker->boolean,
        'board_id' => $faker->numberBetween(1,$boards),
        'author_id' => $faker->numberBetween(1,$users),
    ];
});
