<?php

namespace Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Auth\Models\Permission;
use Rancor\DB\Seeders\RancorSeeder;
use Rancor\Tests\TestCase;

class PermissionModelTest extends TestCase
{
    use RefreshDatabase;

    protected $permission;

    public function setUp(): void
    {
        parent::setUp();

        // Make sure default Permissions are seeed correctly
        $this->seed(RancorSeeder::class);
        $this->assertDatabaseCount('rancor_permissions', 85);

        $permission = Permission::factory()
        ->hasUsers(5)->hasRoles(5)
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
        ]);
        
        $this->assertNotNull($permission);
        $this->permission = $permission->load('roles', 'users');
    }

    /** 
     * @test
     */
    function permission_has_name()
    {
        $this->assertEquals('Fake Title', $this->permission->name);
    }

    /**
     * @test
     */
    function permission_has_description()
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $this->permission->description);
    }

    /**
     * @test
     */
    function permission_has_users()
    {
        $this->assertCount(5, $this->permission->users);
    }

    /**
     * @test
     */
    function permission_has_roles()
    {
        $this->assertCount(5, $this->permission->roles);
    }
}