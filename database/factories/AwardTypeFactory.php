<?php

namespace Rancor\DB\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Rancor\Structure\Models\AwardType;

class AwardTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AwardType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company,
            'description' => $this->faker->text(150),
        ];
    }
}
