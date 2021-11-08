<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Auth\Models\Permission;
use AndrykVP\Rancor\Auth\Models\Role;
use AndrykVP\Rancor\DB\Seeders\RancorSeeder;
use AndrykVP\Rancor\Tests\TestCase;

class RoleModelTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        // Make sure default Roles are seeed correctly
        $this->seed(RancorSeeder::class);
        $this->assertDatabaseCount('rancor_roles', 9);

        $role = Role::factory()
        ->hasUsers(5)->hasPermissions(5)
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
        ]);
        
        $this->assertNotNull($role);
        $this->role = $role->load('permissions', 'users');
    }

    /** 
     * @test
     */
    function role_has_name()
    {
        $this->assertEquals('Fake Title', $this->role->name);
    }

    /**
     * @test
     */
    function role_has_description()
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $this->role->description);
    }

    /**
     * @test
     */
    function role_has_users()
    {
        $this->assertCount(5, $this->role->users);
    }

    /**
     * @test
     */
    function role_has_permissions()
    {
        $this->assertCount(5, $this->role->permissions);
    }
}