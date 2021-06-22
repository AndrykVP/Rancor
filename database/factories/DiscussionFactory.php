<?php

namespace AndrykVP\Rancor\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\Forums\Models\Discussion;

class DiscussionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discussion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->title,
            'is_sticky' => $this->faker->boolean,
            'is_locked' => $this->faker->boolean,
        ];
    }

    /**
     * Indicate that the Discussion is sticky
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function sticky($value = true)
    {
        return $this->state(function (array $attributes) use($value) {
            return [
                'is_sticky' => $value,
            ];
        });
    }

    /**
     * Indicate that the Discussion is locked
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function locked($value = true)
    {
        return $this->state(function (array $attributes) use($value) {
            return [
                'is_locked' => $value,
            ];
        });
    }
}