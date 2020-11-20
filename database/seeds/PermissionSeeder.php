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
                'name' => 'view-users',
                'description' => 'Can visit the profile of a User other than himself'
            ],
            [
                'name' => 'update-users',
                'description' => 'Can edit all information of Users'
            ],
            [
                'name' => 'update-users-art',
                'description' => 'Can update the ID images of a User'
            ],
            [
                'name' => 'update-users-rank',
                'description' => 'Can update the Rank of a User'
            ],
            [
                'name' => 'delete-users',
                'description' => 'Can delete Users'
            ],
            [
                'name' => 'view-roles',
                'description' => 'Can view Roles'
            ],
            [
                'name' => 'create-roles',
                'description' => 'Can create Roles'
            ],
            [
                'name' => 'update-roles',
                'description' => 'Can edit Roles'
            ],
            [
                'name' => 'delete-roles',
                'description' => 'Can delete Roles'
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
                'name' => 'update-factions',
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
                'name' => 'update-departments',
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
                'name' => 'update-ranks',
                'description' => 'Can edit Ranks'
            ],
            [
                'name' => 'delete-ranks',
                'description' => 'Can delete Ranks'
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
                'name' => 'update-articles',
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
                'name' => 'update-scans',
                'description' => 'Can edit Scans'
            ],
            [
                'name' => 'delete-scans',
                'description' => 'Can delete Scans'
            ],
            [
                'name' => 'view-forum-categories',
                'description' => 'Can view Forum Category'
            ],
            [
                'name' => 'create-forum-categories',
                'description' => 'Can create Forum Category'
            ],
            [
                'name' => 'update-forum-categories',
                'description' => 'Can edit Forum Category'
            ],
            [
                'name' => 'delete-forum-categories',
                'description' => 'Can delete Forum Category'
            ],
            [
                'name' => 'view-forum-boards',
                'description' => 'Can view Forum Board'
            ],
            [
                'name' => 'create-forum-boards',
                'description' => 'Can create Forum Board'
            ],
            [
                'name' => 'update-forum-boards',
                'description' => 'Can edit Forum Board'
            ],
            [
                'name' => 'delete-forum-boards',
                'description' => 'Can delete Forum Board'
            ],
            [
                'name' => 'view-forum-discussions',
                'description' => 'Can view Forum Discussion'
            ],
            [
                'name' => 'create-forum-discussions',
                'description' => 'Can create Forum Discussion'
            ],
            [
                'name' => 'update-forum-discussions',
                'description' => 'Can edit Forum Discussion'
            ],
            [
                'name' => 'delete-forum-discussions',
                'description' => 'Can delete Forum Discussion'
            ],
            [
                'name' => 'view-forum-groups',
                'description' => 'Can view Forum Groups'
            ],
            [
                'name' => 'create-forum-groups',
                'description' => 'Can create Forum Groups'
            ],
            [
                'name' => 'update-forum-groups',
                'description' => 'Can edit Forum Groups'
            ],
            [
                'name' => 'delete-forum-groups',
                'description' => 'Can delete Forum Groups'
            ],
            [
                'name' => 'view-forum-replies',
                'description' => 'Can view Forum Reply'
            ],
            [
                'name' => 'create-forum-replies',
                'description' => 'Can create Forum Reply'
            ],
            [
                'name' => 'update-forum-replies',
                'description' => 'Can edit Forum Reply'
            ],
            [
                'name' => 'delete-forum-replies',
                'description' => 'Can delete Forum Reply'
            ],
        ]);
    }
}
