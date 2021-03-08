<?php

namespace AndrykVP\Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\Scanner\Entry;

class EntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Entry::class;
    protected $users;

    /**
     * Class constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->users = DB::table('users')->count();
    }


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'entity_id' => $this->faker->unique()->randomNumber(9),
            'type' => $this->faker->company,
            'name' => $this->faker->name,
            'owner' => $this->faker->name,
            'position' => [
                'galaxy' => [
                    'x' => rand(0,400),
                    'y' => rand(0,400)
                ],
                'system' => [
                    'x' => rand(0,20),
                    'y' => rand(0,20)
                ],
                'surface' => [
                    'x' => rand(0,20),
                    'y' => rand(0,20)
                ],
                'ground' => [
                    'x' => rand(0,20),
                    'y' => rand(0,20)
                ],
            ],
            'last_seen' => now(),
            'updated_by' => $this->faker->numberBetween(1,$this->users)
        ];
    }
}