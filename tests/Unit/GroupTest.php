<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Forums\Models\Group;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    protected $group;

    public function setUp(): void
    {
        parent::setUp();

        $group = Group::factory()
        ->hasUsers(3)
        ->hasAttached(Board::factory()->count(2)->forCategory()->create())
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
        ]);
        
        $this->assertNotNull($group);
        $this->group = $group->load('users','boards');
    }

    /** 
     * @test
     */
    function group_has_name()
    {
        $this->assertEquals('Fake Title', $this->group->name);
    }

    /**
     * @test
     */
    function group_has_description()
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $this->group->description);
    }

    /**
     * @test
     */
    function group_has_users()
    {
        $this->assertCount(3, $this->group->users);
    }
    
    /**
     * @test
     */
    function group_has_boards()
    {
        $this->assertCount(2, $this->group->boards);
    }
}