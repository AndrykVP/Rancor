<?php

namespace Rancor\DB\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Rancor\Audit\Models\UserLog;
use App\Models\User;

class UserLogFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = UserLog::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'user_id' => User::factory(),
			'updated_by' => User::factory(),
			'action' => $this->faker->sentence,
			'color' => $this->faker->hexColor,
		];
	}
}