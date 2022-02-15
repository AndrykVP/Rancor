<?php

namespace Rancor\DB\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RancorSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      $this->call([
         GroupsSeeder::class,
         PermissionsSeeder::class,
         RolesSeeder::class,
         PermissiblesSeeder::class,
         TerritoryTypesSeeder::class,
      ]);
   }
}