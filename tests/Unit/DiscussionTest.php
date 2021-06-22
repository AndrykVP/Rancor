<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Models\Discussion;
use AndrykVP\Rancor\Tests\TestCase;
use App\Models\User;

class DiscussionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_discussion()
    {
        $discussion = Discussion::factory()
        ->for(Board::factory()->forCategory()->create())
        ->for(User::factory()->create(), 'author')
        ->sticky()->locked()
        ->create([
            'name' => 'Fake Title',
            'views' => 10
        ]);
        $this->assertNotNull($discussion);
        return $discussion;
    }

    /** 
     * @test
     * @depends make_discussion
     */
    function discussion_has_name($discussion)
    {
        $this->assertEquals('Fake Title', $discussion->name);
    }

    /** 
     * @test
     * @depends make_discussion
     */
    function discussion_has_board($discussion)
    {
        $this->assertNotNull($discussion->board_id);
    }

    /** 
     * @test
     * @depends make_discussion
     */
    function discussion_is_sticky($discussion)
    {
        $this->assertEquals(true, $discussion->is_sticky);
    }

    /** 
     * @test
     * @depends make_discussion
     */
    function discussion_is_locked($discussion)
    {
        $this->assertEquals(true, $discussion->is_locked);
    }

    /** 
     * @test
     * @depends make_discussion
     */
    function discussion_has_views($discussion)
    {
        $this->assertEquals(10, $discussion->views);
    }
}