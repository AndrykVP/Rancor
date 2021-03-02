<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\News\Article;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Article::class, function (Faker $faker) {
    $users = DB::table('users')->count();
    return [
        'name' => $faker->company,
        'body' => $faker->paragraph(10),
        'description' => $faker->text(150),
        'is_published' => $faker->boolean,
        'author_id' => $faker->numberBetween(1,$users),
        'editor_id' => $faker->numberBetween(1,$users),
    ];
});
