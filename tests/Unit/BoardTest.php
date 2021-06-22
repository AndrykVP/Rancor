<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Models\Discussion;
use AndrykVP\Rancor\Tests\TestCase;

class BoardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_board()
    {
        $board = Board::factory()
        ->forCategory()
        ->has(Discussion::factory()->count(4)->forAuthor())
        ->hasModerators(2)
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
            'slug' => 'lorem',
            'lineup' => 1
        ]);
        $this->assertNotNull($board);
        return $board->load('discussions', 'moderators');
    }

    /** 
     * @test
     * @depends make_board
     */
    function board_has_name($board)
    {
        $this->assertEquals('Fake Title', $board->name);
    }

    /**
     * @test
     * @depends make_board
     */
    function board_has_description($board)
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $board->description);
    }

    /**
     * @test
     * @depends make_board
     */
    function board_has_slug($board)
    {
        $this->assertEquals('lorem', $board->slug);
    }

    /**
     * @test
     * @depends make_board
     */
    function board_has_category($board)
    {
        $this->assertNotNull($board->category_id);
    }

    /**
     * @test
     * @depends make_board
     */
    function board_has_lineup($board)
    {
        $this->assertEquals(1, $board->lineup);
    }

    /**
     * @test
     * @depends make_board
     */
    function board_is_parent($board)
    {
        $this->assertNull($board->parent_id);
    }

    /**
     * @test
     * @depends make_board
     */
    function board_has_no_children($board)
    {
        $this->assertEmpty($board->children);
    }

    /**
     * @test
     * @depends make_board
     */
    function board_has_discussions($board)
    {
        $this->assertCount(4, $board->discussions);
    }

    /**
     * @test
     * @depends make_board
     */
    function board_has_moderators($board)
    {
        $this->assertCount(2, $board->moderators);
    }
}