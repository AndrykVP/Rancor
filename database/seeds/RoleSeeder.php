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
                'name' => 'SuperAdmin',
                'description' => 'Has all permissions available',
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
    }
}
