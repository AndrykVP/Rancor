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
            'name' => 'User Manager',
            'description' => 'Can edit and delete users',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'Faction Manager',
            'description' => 'Can create and edit factions, departments and ranks',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'Role Manager',
            'description' => 'Can create and edit roles and permissions',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'CO / XO',
            'description' => 'Can change a User\'s rank, department and/or faction',
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
            'description' => 'Can create and edit news articles',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'Scout Team',
            'description' => 'Can view and upload scanner entries',
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
            'name' => 'Holocron Recorder',
            'description' => 'Can create and edit holocron nodes and collections',
            'created_at' => now(),
            'updated_at' => now(),
         ],
      ]);
   }
}