<?php

namespace Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Forums\Models\Board;
use Rancor\Forums\Models\Discussion;
use Rancor\Forums\Models\Reply;
use Rancor\Tests\TestCase;

class ReplyModelTest extends TestCase
{
    use RefreshDatabase;

    protected $reply;

    public function setUp(): void
    {
        parent::setUp();

        $reply = Reply::factory()
        ->for(Discussion::factory()->for(Board::factory()->forCategory())->forAuthor())
        ->forAuthor()->forEditor()
        ->create([
            'body' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
        ]);

        $this->assertNotNull($reply);
        $this->reply = $reply;
    }

    /**
     * @test
     */
    function reply_has_body()
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $this->reply->body);
    }

    /**
     * @test
     */
    function reply_has_discussion()
    {
        $this->assertNotNull($this->reply->discussion_id);
    }

    /**
     * @test
     */
    function reply_has_author()
    {
        $this->assertNotNull($this->reply->created_by);
    }

    /**
     * @test
     */
    function reply_has_editor()
    {
        $this->assertNotNull($this->reply->updated_by);
    }
}