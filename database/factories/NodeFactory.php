<?php

namespace AndrykVP\Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\Holocron\Node;

class NodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Node::class;
    protected $users;

    /**
     * Class constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->users = DB::table('users')->count();
    }


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company,
            'body' => $this->faker->paragraph(true),
            'author_id' => $this->faker->numberBetween(1, $this->users),
            'editor_id' => $this->faker->numberBetween(1, $this->users),
            'is_public' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}