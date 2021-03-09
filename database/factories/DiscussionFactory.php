<?php

namespace AndrykVP\Rancor\Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\Forums\Discussion;

class DiscussionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discussion::class;
    protected $boards, $users;

    /**
     * Class constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->boards = DB::table('forum_boards')->count();
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
            'name' => $this->faker->sentence(4),
            'is_sticky' => $this->faker->boolean,
            'is_locked' => $this->faker->boolean,
            'board_id' => $this->faker->numberBetween(1,$this->boards),
            'author_id' => $this->faker->numberBetween(1,$this->users),
        ];
    }
}