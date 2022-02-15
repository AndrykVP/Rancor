<?php

namespace Rancor\DB\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Rancor\Audit\Models\BanLog;
use App\Models\User;

class BanLogFactory extends Factory
{
   /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
   protected $model = BanLog::class;


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
         'reason' => $this->faker->sentence,
         'status' => $this->faker->boolean,
      ];
   }
}