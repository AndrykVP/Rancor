<?php

namespace AndrykVP\Rancor\DB\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TerritoryTypesSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      /**
       * Inserts Default Roles
       */
      DB::table('scanner_territory_types')->insert([
         [
            'name' => 'System',
            'image' => storage_path('territory_types/system.png'),
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'Asteroid Field',
            'image' => storage_path('territory_types/asteroid.png'),
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'Station',
            'image' => storage_path('territory_types/station.png'),
            'created_at' => now(),
            'updated_at' => now(),
         ],
      ]);
   }
}