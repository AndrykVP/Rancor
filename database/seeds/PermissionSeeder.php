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
        DB::table('permissions')->insert([
            [
                'name' => 'view-roles',
                'description' => 'Can view Roles'
            ],
            [
                'name' => 'create-roles',
                'description' => 'Can create Roles'
            ],
            [
                'name' => 'edit-roles',
                'description' => 'Can edit Roles'
            ],
            [
                'name' => 'delete-roles',
                'description' => 'Can delete Roles'
            ],
            [
                'name' => 'view-articles',
                'description' => 'Can view News Articles'
            ],
            [
                'name' => 'create-articles',
                'description' => 'Can create News Articles'
            ],
            [
                'name' => 'edit-articles',
                'description' => 'Can edit News Articles'
            ],
            [
                'name' => 'delete-articles',
                'description' => 'Can delete News Articles'
            ],
            [
                'name' => 'view-scans',
                'description' => 'Can view Scans'
            ],
            [
                'name' => 'create-scans',
                'description' => 'Can create Scans'
            ],
            [
                'name' => 'edit-scans',
                'description' => 'Can edit Scans'
            ],
            [
                'name' => 'delete-scans',
                'description' => 'Can delete Scans'
            ],
            [
                'name' => 'view-factions',
                'description' => 'Can view Factions'
            ],
            [
                'name' => 'create-factions',
                'description' => 'Can create Factions'
            ],
            [
                'name' => 'edit-factions',
                'description' => 'Can edit Factions'
            ],
            [
                'name' => 'delete-factions',
                'description' => 'Can delete Factions'
            ],
            [
                'name' => 'view-departments',
                'description' => 'Can view Departments'
            ],
            [
                'name' => 'create-departments',
                'description' => 'Can create Departments'
            ],
            [
                'name' => 'edit-departments',
                'description' => 'Can edit Departments'
            ],
            [
                'name' => 'delete-departments',
                'description' => 'Can delete Departments'
            ],
            [
                'name' => 'view-ranks',
                'description' => 'Can view Ranks'
            ],
            [
                'name' => 'create-ranks',
                'description' => 'Can create Ranks'
            ],
            [
                'name' => 'edit-ranks',
                'description' => 'Can edit Ranks'
            ],
            [
                'name' => 'delete-ranks',
                'description' => 'Can delete Ranks'
            ],
            [
                'name' => 'view-users',
                'description' => 'Can visit the profile of a User other than himself'
            ],
            [
                'name' => 'edit-users',
                'description' => 'Can edit all information of Users'
            ],
            [
                'name' => 'edit-users-art',
                'description' => 'Can update the ID images of a User'
            ],
            [
                'name' => 'edit-users-rank',
                'description' => 'Can update the Rank of a User'
            ],
            [
                'name' => 'delete-users',
                'description' => 'Can delete Users'
            ],
        ]);
    }
}
