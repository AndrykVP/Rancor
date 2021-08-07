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
      $permissions = DB::table('rancor_permissions')->count();

      for($i = 1; $i <= $permissions; $i++)
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
         2 => [1,2,3,4,5,6,7,8],
         3 => [1,17,18,19,21,22,23,25,26,27],
         4 => [1,9,11,13,14],
         5 => [1,5,3],
         6 => [1,5,2],
         7 => [1,29,30,31,33,34,35],
         8 => [1,33,37,38],
         9 => [1,41,42,43,45,46,47,49,50,51,53,54,55,57,58,59],
         10 => [1,69,70,71,73,74,75]
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