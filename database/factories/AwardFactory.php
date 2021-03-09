<?php

namespace AndrykVP\Rancor\Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\Structure\Award;

class AwardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Award::class;
    protected $types;

    /**
     * Class constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->types = DB::table('structure_award_types')->count();
    }


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company,
            'code' => strtoupper($this->faker->unique()->word),
            'description' => $this->faker->text(150),
            'type_id' => $this->faker->numberBetween(1,$this->types),
            'levels' => $this->faker->numberBetween(1,12),
            'priority' => $this->faker->numberBetween(1,20),
        ];
    }
}