<?php

namespace AndrykVP\Rancor\DB\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use AndrykVP\Rancor\Audit\Models\IPLog;
use App\Models\User;

class IPLogFactory extends Factory
{
   /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
   protected $model = IPLog::class;

   /**
    * Define the model's default state.
    *
    * @return array
    */
   public function definition()
   {
      return [
         'user_id' => User::factory(),
         'ip_address' => $this->faker->ipv4,
         'user_agent' => $this->faker->userAgent,
         'type' => $this->faker->randomElement(['login', 'registration']),
      ];
   }
}