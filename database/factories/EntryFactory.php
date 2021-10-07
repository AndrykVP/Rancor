<?php

namespace AndrykVP\Rancor\DB\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\Scanner\Models\Entry;

class EntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Entry::class;
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
                'galaxy' => $this->coordinates(),
                'system' => $this->coordinates()
            ],
            'territory_id' => $this->faker->numberBetween(1, 5929),
            'last_seen' => now(),
        ];
    }

    /**
     * Indicate that the Entry is in atmosphere
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function atmosphere()
    {
        return $this->state(function (array $attributes) {
            return [
                'position' => [
                    'atmosphere' => $this->coordinates()
                ],
            ];
        });
    }

    /**
     * Indicate that the Entry is on the surface
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function ground()
    {
        return $this->state(function (array $attributes) {
            return [
                'position' => [
                    'ground' => $this->coordinates()
                ],
            ];
        });
    }

    /**
     * Returns random X and Y coordinates
     * 
     * @return array
     */
    private function coordinates()
    {
        return [
            'x' => rand(0,20),
            'y' => rand(0,20)
        ];
    }

}