<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Structure\Models\Department;
use AndrykVP\Rancor\Structure\Models\Rank;
use AndrykVP\Rancor\Tests\TestCase;

class RankTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_rank()
    {
        $rank = Rank::factory()
        ->for(Department::factory()->forFaction())->hasUsers(7)
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
            'level' => 12,
            'color' => '#123456'
        ]);
        $this->assertNotNull($rank);
        return $rank->load('users');
    }

    /** 
     * @test
     * @depends make_rank
     */
    function rank_has_name($rank)
    {
        $this->assertEquals('Fake Title', $rank->name);
    }

    /**
     * @test
     * @depends make_rank
     */
    function rank_has_description($rank)
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $rank->description);
    }

    /**
     * @test
     * @depends make_rank
     */
    function rank_has_level($rank)
    {
        $this->assertEquals(12, $rank->level);
    }

    /**
     * @test
     * @depends make_rank
     */
    function rank_has_color($rank)
    {
        $this->assertEquals('#123456', $rank->color);
    }
    
    /**
     * @test
     * @depends make_rank
     */
    function rank_has_department($rank)
    {
        $this->assertNotNull($rank->department_id);
    }
    
    /**
     * @test
     * @depends make_rank
     */
    function rank_has_users($rank)
    {
        $this->assertCount(7, $rank->users);
    }
}