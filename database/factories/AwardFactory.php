<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AndrykVP\Rancor\Structure\Award;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Award::class, function (Faker $faker) {
    $types = DB::table('structure_award_types')->count();
    return [
        'name' => $faker->unique()->company,
        'code' => strtoupper($faker->unique()->word),
        'description' => $faker->text(150),
        'type_id' => $faker->numberBetween(1,$types),
        'levels' => $faker->numberBetween(1,12),
        'priority' => $faker->numberBetween(1,20),
    ];
});
