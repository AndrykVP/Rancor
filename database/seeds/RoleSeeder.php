<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rancor_roles')->insert([
            [
                'name' => 'Admin',
                'description' => 'Has all permissions available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User Manager',
                'description' => 'Can create, edit or delete users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Faction Manager',
                'description' => 'Can create, edit or delete factions, departments and ranks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Role Manager',
                'description' => 'Can create, edit or delete roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CO / XO',
                'description' => 'Can change a user\'s rank, department and/or faction',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Art Team',
                'description' => 'Can upload avatar and signature artwork',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'News Team',
                'description' => 'Can create, edit and delete news articles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Scout Team',
                'description' => 'Can view and upload to the Reconnaisance Center',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Forum Manager',
                'description' => 'Can create, edit and delete forum categories, boards and usergroups',
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
            2 => [1,2,3,4,5],
            3 => [10,11,12,13,14,15,16,17,18,19,20,21],
            4 => [6,7,8,9],
            5 => [1,4],
            6 => [1,3],
            7 => [22,23,24,25],
            8 => [26,27,28,29],
            9 => [30,31,32,33,34,35,36,37,38,39,40,41,42,43,45,46,47,48,49],
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
