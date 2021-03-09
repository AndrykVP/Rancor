<?php

namespace AndrykVP\Rancor\Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\News\Article;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;
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
            'name' => $this->faker->company,
            'body' => $this->faker->paragraph(10),
            'description' => $this->faker->text(150),
            'is_published' => $this->faker->boolean,
            'author_id' => $this->faker->numberBetween(1,$this->users),
            'editor_id' => $this->faker->boolean ? $this->faker->numberBetween(1,$this->users) : null,
        ];
    }
}