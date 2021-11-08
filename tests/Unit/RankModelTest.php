<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Structure\Models\Department;
use AndrykVP\Rancor\Structure\Models\Rank;
use AndrykVP\Rancor\Tests\TestCase;

class RankModelTest extends TestCase
{
    use RefreshDatabase;

    protected $rank;

    public function setUp(): void
    {
        parent::setUp();

        $rank = Rank::factory()
        ->for(Department::factory()->forFaction())
        ->hasUsers(7)
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
            'level' => 12,
            'color' => '#123456'
        ]);

        $this->assertNotNull($rank);
        $this->rank = $rank->load('users');
    }

    /** 
     * @test
     */
    function rank_has_name()
    {
        $this->assertEquals('Fake Title', $this->rank->name);
    }

    /**
     * @test
     */
    function rank_has_description()
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $this->rank->description);
    }

    /**
     * @test
     */
    function rank_has_level()
    {
        $this->assertEquals(12, $this->rank->level);
    }

    /**
     * @test
     */
    function rank_has_color()
    {
        $this->assertEquals('#123456', $this->rank->color);
    }
    
    /**
     * @test
     */
    function rank_has_department()
    {
        $this->assertNotNull($this->rank->department_id);
    }
    
    /**
     * @test
     */
    function rank_has_users()
    {
        $this->assertCount(7, $this->rank->users);
    }
}