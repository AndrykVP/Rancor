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
                'name' => 'User Manager',
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
                'name' => 'Scout Team',
                'description' => 'Can view and upload to the Reconnaisance Center',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'News Team',
                'description' => 'Can create, edit and delete news articles',
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
            2 => [13,14,15,16,17,18,19,20,21,22,23,24,25],
            3 => [1,2,3,4],
            4 => [26,27,28,29,30],
            5 => [26,29],
            6 => [26,28],
            7 => [9,10,11,12],
            8 => [5,6,7,8],
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
