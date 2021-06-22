<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Forums\Models\Group;
use AndrykVP\Rancor\Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_group()
    {
        $group = Group::factory()
        ->hasUsers(3)
        ->hasCategories(2)
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
        ]);
        $this->assertNotNull($group);
        return $group->load('users','categories');
    }

    /** 
     * @test
     * @depends make_group
     */
    function group_has_name($group)
    {
        $this->assertEquals('Fake Title', $group->name);
    }

    /**
     * @test
     * @depends make_group
     */
    function group_has_description($group)
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $group->description);
    }

    /**
     * @test
     * @depends make_group
     */
    function group_has_users($group)
    {
        $this->assertCount(3, $group->users);
    }
    
    /**
     * @test
     * @depends make_group
     */
    function group_has_categories($group)
    {
        $this->assertCount(2, $group->categories);
    }
}