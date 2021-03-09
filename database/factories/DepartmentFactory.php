<?php

namespace AndrykVP\Rancor\Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\Structure\Department;

class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;
    protected $factions;

    /**
     * Class constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->factions = DB::table('structure_factions')->count();
    }


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->catchPhrase,
            'color' => $this->faker->hexcolor,
            'faction_id' => $this->faker->numberBetween(1,$this->factions),
        ];
    }
}