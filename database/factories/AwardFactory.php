<?php

namespace Rancor\DB\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Rancor\Structure\Models\Award;

class AwardFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Award::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'name' => $this->faker->unique()->company,
			'code' => strtoupper($this->faker->unique()->word),
			'description' => $this->faker->text(150),
			'levels' => $this->faker->numberBetween(1,12),
			'priority' => $this->faker->numberBetween(1,20),
		];
	}
}