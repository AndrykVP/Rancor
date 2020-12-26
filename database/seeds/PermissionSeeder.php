<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [
            'users',
            'roles',
            'permissions',
            'factions',
            'departments',
            'ranks',
            'articles',
            'tags',
            'scanner-entries',
            'forum-groups',
            'forum-categories',
            'forum-boards',
            'forum-discussions',
            'forum-replies',
        ];

        $permissions = [
            'view',
            'create',
            'update',
            'delete',
        ];

        foreach($modules as $module)
        {
            foreach($permissions as $permission)
            {
                DB::table('permissions')->insert([
                    'name' => $permission . '-' . $module,
                    'description' => 'Can ' . $permission . ucwords(str_replace('-',' ',$module))
                ]);
            }
        }

        DB::table('permissions')->insert([
            [
                'name' => 'update-users-art',
                'description' => 'Can update a User\'s ID images'
            ],
            [
                'name' => 'update-users-rank',
                'description' => 'Can update a User\'s Rank'
            ],
            [
                'name' => 'update-users-roles',
                'description' => 'Can update a User\'s Roles'
            ],
            [
                'name' => 'view-admin-panel',
                'description' => 'Can access admin panel'
            ],
        ]);
    }
}
