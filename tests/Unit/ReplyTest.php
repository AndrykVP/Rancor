<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Models\Discussion;
use AndrykVP\Rancor\Forums\Models\Reply;
use AndrykVP\Rancor\Tests\TestCase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_reply()
    {
        $reply = Reply::factory()
        ->for(Discussion::factory()->for(Board::factory()->forCategory())->forAuthor())
        ->forAuthor()->forEditor()
        ->create([
            'body' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
        ]);
        $this->assertNotNull($reply);
        return $reply;
    }

    /**
     * @test
     * @depends make_reply
     */
    function reply_has_body($reply)
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $reply->body);
    }

    /**
     * @test
     * @depends make_reply
     */
    function reply_has_discussion($reply)
    {
        $this->assertNotNull($reply->discussion_id);
    }

    /**
     * @test
     * @depends make_reply
     */
    function reply_has_author($reply)
    {
        $this->assertNotNull($reply->author_id);
    }

    /**
     * @test
     * @depends make_reply
     */
    function reply_has_editor($reply)
    {
        $this->assertNotNull($reply->editor_id);
    }
}