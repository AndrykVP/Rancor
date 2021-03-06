<?php

namespace AndrykVP\Rancor\DB\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\Holocron\Models\Node;

class NodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Node::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->sentence(5),
            'body' => $this->faker->paragraph(true),
            'is_public' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the Node is not public
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function privte()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_public' => false
            ];
        });
    }
}