<?php

namespace Rancor\DB\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Rancor\Scanner\Models\Quadrant;

class QuadrantFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Quadrant::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'x_min' => $this->faker->numberBetween(-500, 500),
			'x_max' => $this->faker->numberBetween(-500, 500),
			'y_min' => $this->faker->numberBetween(-500, 500),
			'y_max' => $this->faker->numberBetween(-500, 500),
		];
	}
}