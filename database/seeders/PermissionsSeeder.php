<?php

namespace AndrykVP\Rancor\DB\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      /**
       * Inserts the Default permissions
       */

      $modules = [
         'users',
         'roles',
         'permissions',
         'structure-factions',
         'structure-departments',
         'structure-ranks',
         'news-articles',
         'news-tags',
         'scanner-entries',
         'forum-groups',
         'forum-categories',
         'forum-boards',
         'forum-discussions',
         'forum-replies',
         'structure-awards',
         'structure-award-types',
         'holocron-nodes',
         'holocron-collections'
      ];

      $permissions = [
         'view',
         'create',
         'update',
         'delete',
      ];

      DB::table('rancor_permissions')->insert([
         [
            'name' => 'view-admin-panel',
            'description' => 'Can access admin panel',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'update-users-art',
            'description' => 'Can update a User\'s ID images',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'update-users-rank',
            'description' => 'Can update a User\'s Rank',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'update-users-roles',
            'description' => 'Can update a User\'s Roles',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'update-users-awards',
            'description' => 'Can update a User\'s Awards',
            'created_at' => now(),
            'updated_at' => now(),
         ],
      ]);

      foreach($modules as $module)
      {
         foreach($permissions as $permission)
         {
            DB::table('rancor_permissions')->insert([
               'name' => $permission . '-' . $module,
               'description' => 'Can ' . $permission . ' ' .ucwords(str_replace('-',' ',$module)),
               'created_at' => now(),
               'updated_at' => now(),
            ]);
         }
      }
   }
}