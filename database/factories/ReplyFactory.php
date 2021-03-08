<?php

namespace AndrykVP\Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\Forum\Reply;

class ReplyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reply::class;
    protected $discussions, $users;

    /**
     * Class constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->discussions = DB::table('forum_discussions')->count();
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
            'discussion_id' => $this->faker->numberBetween(1,$this->discussions),
            'author_id' => $this->faker->numberBetween(1,$this->users),
            'body' => $this->faker->paragraph(true),
        ];
    }
}