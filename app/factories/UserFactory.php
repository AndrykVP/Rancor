<?php

namespace App\Factories;

use App\Models\User;
use Orchestra\Testbench\Factories\UserFactory as TestbenchUserFactory;

class UserFactory extends TestbenchUserFactory
{
  protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'avatar' => 'https://dummyimage.com/150x150/333/fff',
            'signature' => '<center><img src="https://dummyimage.com/400x120/333/fff" /></center>',
            'nickname' => $this->faker->word,
            'quote' => $this->faker->catchphrase,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }
}