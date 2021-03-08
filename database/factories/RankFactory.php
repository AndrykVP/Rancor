<?php

namespace AndrykVP\Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\Structure\Rank;

class RankFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rank::class;
    protected $departments;

    /**
     * Class constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->departments = DB::table('structure_departments')->count();
    }


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle,
            'description' => $this->faker->text(150),
            'color' => $this->faker->hexcolor,
            'department_id' => $this->faker->numberBetween(1,$this->departments),
            'level' => $this->faker->numberBetween(1,12),
        ];
    }
}