<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Models\Discussion;
use AndrykVP\Rancor\Tests\TestCase;

class BoardModelTest extends TestCase
{
    use RefreshDatabase;

    protected $board;

    public function setUp(): void
    {
        parent::setUp();

        $board = Board::factory()
        ->forCategory()
        ->hasGroups(2)
        ->has(Discussion::factory()->count(4)->forAuthor())
        ->hasModerators(2)
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
            'slug' => 'lorem',
            'lineup' => 1
        ]);
        
        $this->assertNotNull($board);
        $this->board = $board->load('children', 'discussions', 'groups', 'moderators');
    }

    /** 
     * @test
     */
    function board_has_name()
    {
        $this->assertEquals('Fake Title', $this->board->name);
    }

    /**
     * @test
     */
    function board_has_description()
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $this->board->description);
    }

    /**
     * @test
     */
    function board_has_slug()
    {
        $this->assertEquals('lorem', $this->board->slug);
    }

    /**
     * @test
     */
    function board_has_category()
    {
        $this->assertNotNull($this->board->category_id);
    }

    /**
     * @test
     */
    function board_has_lineup()
    {
        $this->assertEquals(1, $this->board->lineup);
    }

    /**
     * @test
     */
    function board_is_not_parent()
    {
        $this->assertNull($this->board->parent_id);
    }

    /**
     * @test
     */
    function board_has_no_children()
    {
        $this->assertEmpty($this->board->children);
    }

    /**
     * @test
     */
    function board_has_discussions()
    {
        $this->assertCount(4, $this->board->discussions);
    }

    /**
     * @test
     */
    function board_has_moderators()
    {
        $this->assertCount(2, $this->board->moderators);
    }

    /**
     * @test
     */
    function board_has_groups()
    {
        $this->assertCount(2, $this->board->groups);
    }
}