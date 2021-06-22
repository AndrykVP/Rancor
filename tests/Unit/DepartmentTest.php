<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Structure\Models\Department;
use AndrykVP\Rancor\Tests\TestCase;

class DepartmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_department()
    {
        $department = Department::factory()
        ->forFaction()->hasRanks(7)
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
            'color' => '#123456'
        ]);
        $this->assertNotNull($department);
        return $department->load('ranks');
    }

    /** 
     * @test
     * @depends make_department
     */
    function department_has_name($department)
    {
        $this->assertEquals('Fake Title', $department->name);
    }

    /**
     * @test
     * @depends make_department
     */
    function department_has_description($department)
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $department->description);
    }

    /**
     * @test
     * @depends make_department
     */
    function department_has_color($department)
    {
        $this->assertEquals('#123456', $department->color);
    }
    
    /**
     * @test
     * @depends make_department
     */
    function department_has_faction($department)
    {
        $this->assertNotNull($department->faction_id);
    }
    
    /**
     * @test
     * @depends make_department
     */
    function department_has_ranks($department)
    {
        $this->assertCount(7, $department->ranks);
    }
}