<?php

namespace AndrykVP\Rancor\Database\Seeders;

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
      /**
       * Adds the Default usergroup for forum usage
       */
      DB::table('forum_groups')->insert([
         [
            'name' => 'Guests',
            'description' => 'Default usergroup for new members',
            'created_at' => now(),
            'updated_at' => now(),
         ]
      ]);

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

      DB::table('rancor_permissions')->insert([
         [
            'name' => 'grant-structure-awards',
            'description' => 'Can give an award to a User',
            'created_at' => now(),
            'updated_at' => now(),
         ],
         [
            'name' => 'revoke-structure-awards',
            'description' => 'Can take an award away from a User',
            'created_at' => now(),
            'updated_at' => now(),
         ],
      ]);

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