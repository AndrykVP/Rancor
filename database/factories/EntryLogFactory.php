<?php

namespace Rancor\DB\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Rancor\Audit\Models\EntryLog;
use Rancor\Scanner\Enums\Alliance;
use Rancor\Scanner\Models\Entry;
use Rancor\Scanner\Models\Territory;
use App\Models\User;

class EntryLogFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = EntryLog::class;


	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'entry_id' => Entry::factory(),
			'updated_by' => User::factory(),
			'old_type' => $this->faker->word,
			'old_name' => $this->faker->unique()->firstName,
			'old_owner' => $this->faker->name,
			'old_alliance' => $this->faker->randomElement(Alliance::cases()),
			'old_territory_id' => Territory::factory()->forQuadrant(),
		];
	}
}