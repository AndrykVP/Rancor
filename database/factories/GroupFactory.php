<?php

namespace Rancor\DB\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Rancor\Forums\Models\Group;

class GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Group::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle,
            'description' => $this->faker->catchPhrase,
        ];
    }
}