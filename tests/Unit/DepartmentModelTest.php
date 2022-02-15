<?php

namespace Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Structure\Models\Department;
use Rancor\Tests\TestCase;

class DepartmentModelTest extends TestCase
{
    use RefreshDatabase;

    protected $department;

    public function setUp(): void
    {
        parent::setUp();

        $department = Department::factory()
        ->forFaction()->hasRanks(7)
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
            'color' => '#123456'
        ]);
        
        $this->assertNotNull($department);
        $this->department = $department->load('ranks');
    }

    /** 
     * @test
     */
    function department_has_name()
    {
        $this->assertEquals('Fake Title', $this->department->name);
    }

    /**
     * @test
     */
    function department_has_description()
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $this->department->description);
    }

    /**
     * @test
     */
    function department_has_color()
    {
        $this->assertEquals('#123456', $this->department->color);
    }
    
    /**
     * @test
     */
    function department_has_faction()
    {
        $this->assertNotNull($this->department->faction_id);
    }
    
    /**
     * @test
     */
    function department_has_ranks()
    {
        $this->assertCount(7, $this->department->ranks);
    }
}