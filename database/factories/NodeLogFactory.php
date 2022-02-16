<?php

namespace Rancor\DB\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Rancor\Audit\Models\NodeLog;
use Rancor\Holocron\Models\Node;
use App\Models\User;

class NodeLogFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = NodeLog::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'node_id' => Node::factory()->forAuthor(),
			'updated_by' => User::factory(),
			'old_name' => $this->faker->word,
			'old_body' => $this->faker->text,
		];
	}
}