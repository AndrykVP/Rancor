<?php

namespace AndrykVP\Rancor\DB\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
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
      DB::table('rancor_roles')->insert([
         [
            'name' => 'Admin',
            'description' => 'Has all permissions available',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'Faction Manager',
            'description' => 'Can create and edit factions, departments, ranks and awards',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'Access Manager',
            'description' => 'Can create and edit roles and permissions',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'CO / XO',
            'description' => 'Can change a User\'s rank, department, awards and faction',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'Art Team',
            'description' => 'Can upload a User\'s avatar and signature artwork',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'News Team',
            'description' => 'Can create and edit news articles and tags',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'Scanner Manager',
            'description' => 'Can create and edit scanner entries, territories and territory types',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'Forum Manager',
            'description' => 'Can create and edit forum categories, boards and usergroups',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'Holocron Manager',
            'description' => 'Can create and edit holocron nodes and collections',
            'created_at' => now(),
            'updated_at' => now(),
         ],
      ]);
   }
}