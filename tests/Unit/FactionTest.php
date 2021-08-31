<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Structure\Models\Faction;
use AndrykVP\Rancor\Tests\TestCase;

class FactionTest extends TestCase
{
    use RefreshDatabase;

    protected $faction;

    public function setUp(): void
    {
        parent::setUp();

        $faction = Faction::factory()
        ->hasDepartments(3)
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
        ]);
        
        $this->assertNotNull($faction);
        $this->faction = $faction->load('departments');
    }

    /** 
     * @test
     */
    function faction_has_name()
    {
        $this->assertEquals('Fake Title', $this->faction->name);
    }

    /**
     * @test
     */
    function faction_has_description()
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $this->faction->description);
    }
    
    /**
     * @test
     */
    function faction_has_departments()
    {
        $this->assertCount(3, $this->faction->departments);
    }
}