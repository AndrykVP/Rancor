<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Forums\Models\Category;
use AndrykVP\Rancor\Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_category()
    {
        $category = Category::factory()
        ->hasBoards(3)
        ->hasGroups(2)
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
            'color' => '#123456',
            'slug' => 'lorem',
            'lineup' => 1
        ]);
        $this->assertNotNull($category);
        return $category->load('boards','groups');
    }

    /** 
     * @test
     * @depends make_category
     */
    function category_has_name($category)
    {
        $this->assertEquals('Fake Title', $category->name);
    }

    /**
     * @test
     * @depends make_category
     */
    function category_has_description($category)
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $category->description);
    }

    /**
     * @test
     * @depends make_category
     */
    function category_has_slug($category)
    {
        $this->assertEquals('lorem', $category->slug);
    }

    /**
     * @test
     * @depends make_category
     */
    function category_has_color($category)
    {
        $this->assertEquals('#123456', $category->color);
    }

    /**
     * @test
     * @depends make_category
     */
    function category_has_lineup($category)
    {
        $this->assertEquals(1, $category->lineup);
    }

    /**
     * @test
     * @depends make_category
     */
    function category_has_boards($category)
    {
        $this->assertCount(3, $category->boards);
    }

    /**
     * @test
     * @depends make_category
     */
    function category_has_groups($category)
    {
        $this->assertCount(2, $category->groups);
    }
}