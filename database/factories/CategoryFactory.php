<?php

namespace AndrykVP\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\Forums\Category;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->sentence(12),
            'color' => $this->faker->hexcolor,
            'slug' => $this->faker->unique()->word,
            'order' => $this->faker->unique()->numberBetween(1,20),
        ];
    }
}