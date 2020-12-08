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
        DB::table('roles')->insert([
            [
                'name' => 'Admin',
                'description' => 'Has all permissions available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User Manager',
                'description' => 'Can create, edit or delete roles',
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

        $permissions = DB::table('permissions')->count();

        for($i = 1; $i <= $permissions; $i++)
        {
            DB::table('permissibles')->insert([
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
            3 => [12,13,14,15,16,17,18,19,20,21,22,23],
            4 => [6,7,8,9],
            5 => [1,4],
            6 => [1,3],
            7 => [24,25,26,27],
            8 => [28,29,30,31],
            9 => [32,33,34,35,36,37,38,39,40,41,42,43,45,46,47,48,49,50,51,52],
        ];

        foreach($roles as $role => $privs)
        {
            foreach($privs as $priv)
            {

                DB::table('permissibles')->insert([
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
