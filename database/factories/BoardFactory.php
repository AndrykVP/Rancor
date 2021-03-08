<?php

namespace AndrykVP\Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\Forums\Board;

class BoardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Board::class;
    protected $categories;

    /**
     * Class constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->categories = DB::table('forum_categories')->count();
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
            'description' => $this->faker->sentence(12),
            'category_id' => $this->faker->numberBetween(1,$this->categories),
            'slug' => $this->faker->unique()->word,
            'order' => $this->faker->numberBetween(1,20),
        ];
    }
}