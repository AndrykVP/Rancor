<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\News\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'body' => $faker->paragraph(10),
        'is_published' => $faker->boolean,
        'author_id' => $faker->numberBetween(1,20),
        'editor_id' => $faker->numberBetween(1,20),
    ];
});
