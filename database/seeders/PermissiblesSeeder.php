<?php

namespace AndrykVP\Rancor\DB\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissiblesSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      $permissions = DB::table('rancor_permissions')->get();

      for($i = 1; $i <= $permissions->count(); $i++)
      {
         DB::table('rancor_permissibles')->insert([
            [
               'permission_id' => $i,
               'permissible_id' => 1,
               'permissible_type' => 'roles',
               'created_at' => now(),
               'updated_at' => now(),
            ],
         ]);   
      }

      $roles = [
         // Faction Manager
         2 => $permissions->filter(function($value, $key) {
            return strpos($value->name, 'admin') !== false
                  || strpos($value->name, 'structure-') !== false;
         })->pluck('id'),

         // Access Manager
         3 => $permissions->filter(function($value, $key) {
            return strpos($value->name, 'admin') !== false
                  || strpos($value->name, 'view-any-user') !== false
                  || strpos($value->name, '-roles') !== false
                  || strpos($value->name, '-permission') !== false
                  || strpos($value->name, 'users-roles') !== false;
         })->pluck('id'),

         // CO/XO
         4 => $permissions->filter(function($value, $key) {
            return strpos($value->name, 'admin') !== false
                  || strpos($value->name, 'view-any-user') !== false
                  || strpos($value->name, 'users-rank') !== false
                  || strpos($value->name, 'users-award') !== false;
         })->pluck('id'),

         // Art Team
         5 => $permissions->filter(function($value, $key) {
            return strpos($value->name, 'admin') !== false
                  || strpos($value->name, 'view-any-user') !== false
                  || strpos($value->name, 'users-art') !== false;
         })->pluck('id'),

         // News Team
         6 => $permissions->filter(function($value, $key) {
            return strpos($value->name, 'admin') !== false
                  || strpos($value->name, 'news-') !== false;
         })->pluck('id'),

         // Scanner Manager
         7 => $permissions->filter(function($value, $key) {
            return strpos($value->name, 'admin') !== false
                  || strpos($value->name, 'scanner-') !== false;
         })->pluck('id'),

         // Forum Manager
         8 => $permissions->filter(function($value, $key) {
            return strpos($value->name, 'admin') !== false
                  || strpos($value->name, 'forum-') !== false;
         })->pluck('id'),

         // Holocron Manager
         9 => $permissions->filter(function($value, $key) {
            return strpos($value->name, 'admin') !== false
                  || strpos($value->name, 'holocron-') !== false;
         })->pluck('id'),
      ];

      foreach($roles as $role => $privs)
      {
         foreach($privs as $priv)
         {

            DB::table('rancor_permissibles')->insert([
               [
                  'permission_id' => $priv,
                  'permissible_id' => $role,
                  'permissible_type' => 'roles',
                  'created_at' => now(),
                  'updated_at' => now(),
               ],
            ]); 
         }
      }
   }
}