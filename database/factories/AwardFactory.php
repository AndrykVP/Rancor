<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Structure\Award;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Award::class, function (Faker $faker) {
    $types = DB::table('structure_award_types')->count();
    return [
        'name' => $faker->unique()->company,
        'description' => $faker->text(150),
        'color' => $faker->hexcolor,
        'class_id' => $faker->numberBetween(1,$types),
    ];
});
