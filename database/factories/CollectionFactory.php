<?php

namespace Rancor\DB\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Rancor\Holocron\Models\Collection;

class CollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Collection::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(5),
            'slug' => $this->faker->unique()->word,
            'description' => $this->faker->text(150),
        ];
    }
}