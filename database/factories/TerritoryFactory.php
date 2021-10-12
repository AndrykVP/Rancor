<?php

namespace AndrykVP\Rancor\DB\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\Scanner\Models\Territory;

class TerritoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Territory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'x_coordinate' => $this->faker->numberBetween(-500, 500),
            'y_coordinate' => $this->faker->numberBetween(-500, 500),
            'subscription' => $this->faker->boolean,
        ];
    }
}