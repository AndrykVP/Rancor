<?php

namespace Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Forums\Models\Category;
use Rancor\Tests\TestCase;

class CategoryModelTest extends TestCase
{
    use RefreshDatabase;

    protected $category;

    public function setUp(): void
    {
        parent::setUp();

        $category = Category::factory()
        ->hasBoards(3)
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
            'color' => '#123456',
            'slug' => 'lorem',
            'lineup' => 1
        ]);
        
        $this->assertNotNull($category);
        $this->category = $category->load('boards');
    }

    /** 
     * @test
     */
    function category_has_name()
    {
        $this->assertEquals('Fake Title', $this->category->name);
    }

    /**
     * @test
     */
    function category_has_description()
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $this->category->description);
    }

    /**
     * @test
     */
    function category_has_slug()
    {
        $this->assertEquals('lorem', $this->category->slug);
    }

    /**
     * @test
     */
    function category_has_color()
    {
        $this->assertEquals('#123456', $this->category->color);
    }

    /**
     * @test
     */
    function category_has_lineup()
    {
        $this->assertEquals(1, $this->category->lineup);
    }

    /**
     * @test
     */
    function category_has_boards()
    {
        $this->assertCount(3, $this->category->boards);
    }
}