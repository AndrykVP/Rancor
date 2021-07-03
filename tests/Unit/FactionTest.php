<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Structure\Models\Faction;
use AndrykVP\Rancor\Tests\TestCase;

class FactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_faction()
    {
        $faction = Faction::factory()
        ->hasDepartments(3)
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
        ]);
        $this->assertNotNull($faction);
        return $faction->load('departments');
    }

    /** 
     * @test
     * @depends make_faction
     */
    function faction_has_name($faction)
    {
        $this->assertEquals('Fake Title', $faction->name);
    }

    /**
     * @test
     * @depends make_faction
     */
    function faction_has_description($faction)
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $faction->description);
    }
    
    /**
     * @test
     * @depends make_faction
     */
    function faction_has_departments($faction)
    {
        $this->assertCount(3, $faction->departments);
    }
}