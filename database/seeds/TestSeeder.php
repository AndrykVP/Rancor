<?php

namespace AndrykVP\Rancor\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use AndrykVP\Rancor\Structure\Models\Faction;
use AndrykVP\Rancor\Structure\Models\Department;
use AndrykVP\Rancor\Structure\Models\Rank;

class TestSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      $factions = Faction::factory()->create(4);
      $departments = Department::factory()->count(3)->for($factions)->create();
      $ranks = Rank::factory()->count(12)->for($departments)->create();
   }
}