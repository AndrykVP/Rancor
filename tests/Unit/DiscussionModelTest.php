<?php

namespace Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Forums\Models\Board;
use Rancor\Forums\Models\Discussion;
use Rancor\Forums\Models\Reply;
use Rancor\Tests\TestCase;

class DiscussionModelTest extends TestCase
{
    use RefreshDatabase;

    protected $discussion;

    public function setUp(): void
    {
        parent::setUp();

        $discussion = Discussion::factory()
        ->for(Board::factory()->forCategory())
        ->forAuthor()
        ->has(Reply::factory()->forAuthor()->count(5))
        ->sticky()->locked()
        ->create([
            'name' => 'Fake Title',
            'views' => 10
        ]);
        
        $this->assertNotNull($discussion);
        $this->discussion = $discussion->load('replies');
    }

    /** 
     * @test
     */
    function discussion_has_name()
    {
        $this->assertEquals('Fake Title', $this->discussion->name);
    }

    /** 
     * @test
     */
    function discussion_has_board()
    {
        $this->assertNotNull($this->discussion->board_id);
    }

    /** 
     * @test
     */
    function discussion_has_replies()
    {
        $this->assertCount(5, $this->discussion->replies);
    }

    /** 
     * @test
     */
    function discussion_has_author()
    {
        $this->assertNotNull($this->discussion->author_id);
    }

    /** 
     * @test
     */
    function discussion_is_sticky()
    {
        $this->assertTrue($this->discussion->is_sticky);
    }

    /** 
     * @test
     */
    function discussion_is_locked()
    {
        $this->assertTrue($this->discussion->is_locked);
    }

    /** 
     * @test
     */
    function discussion_has_views()
    {
        $this->assertEquals(10, $this->discussion->views);
    }
}