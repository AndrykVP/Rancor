<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Forums\Reply;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Reply::class, function (Faker $faker) {
    $users = DB::table('users')->count();
    $discussions = DB::table('forum_discussions')->count();
    return [
        'discussion_id' => $faker->numberBetween(1,$discussions),
        'author_id' => $faker->numberBetween(1,$users),
        'body' => $faker->paragraph(true),
    ];
});
