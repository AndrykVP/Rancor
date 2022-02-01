<?php

namespace AndrykVP\Rancor\DB\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\Audit\Models\AwardLog;
use AndrykVP\Rancor\Structure\Models\Award;
use App\Models\User;

class AwardLogFactory extends Factory
{
   /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
   protected $model = AwardLog::class;

   /**
    * Define the model's default state.
    *
    * @return array
    */
   public function definition()
   {
      return [
         'award_id' => Award::factory(),
         'user_id' => User::factory(),
         'action' => $this->faker->randomBetween(-2, 2),
         'updated_by' => User::factory(),
      ];
   }
}