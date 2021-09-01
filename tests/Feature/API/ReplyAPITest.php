<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Models\Discussion;
use AndrykVP\Rancor\Forums\Models\Reply;
use App\Models\User;

class ReplyAPITest extends TestCase
{
   use RefreshDatabase;

   protected $replies, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without replies
      $this->assertDatabaseCount('forum_replies', 0);

      // Initialize Test DB
      $this->replies = Reply::factory()
                     ->for(Discussion::factory()->for(Board::factory()->forCategory())->forAuthor())
                     ->forAuthor()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_reply_api_index()
   {
      $response = $this->getJson(route('api.forums.replies.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_reply_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.forums.replies.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_reply_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->withoutExceptionHandling()
                  ->getJson(route('api.forums.replies.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_reply_api_show()
   {
      $reply = $this->replies->random();
      $response = $this->getJson(route('api.forums.replies.show', $reply));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_reply_api_show()
   {
      $reply = $this->replies->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.forums.replies.show', $reply));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_reply_api_show()
   {
      $reply = $this->replies->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.forums.replies.show', $reply));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $reply->id,
            'body' => clean($reply->body),
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_reply_api_store()
   {
      $response = $this->postJson(route('api.forums.replies.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_reply_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.forums.replies.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_reply_api_store()
   {
      $reply = Reply::factory()->make(['discussion_id' => 1]);
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.forums.replies.store'), $reply->toArray());
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Reply has been posted'
      ]);
   }

   /** @test */
   function guest_cannot_access_reply_api_update()
   {
      $reply = $this->replies->random();
      $response = $this->patchJson(route('api.forums.replies.update', $reply), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_reply_api_update()
   {
      $reply = $this->replies->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.forums.replies.update', $reply), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_reply_api_update()
   {
      $reply = $this->replies->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.forums.replies.update', $reply), [
                     'id' => $reply->id,
                     'body' => 'Updated Reply Body',
                     'discussion_id' => $reply->discussion_id,
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Reply #'. $reply->id .' has been updated'
      ]);
   }
   /** @test */
   function guest_cannot_access_reply_api_destroy()
   {
      $reply = $this->replies->random();
      $response = $this->deleteJson(route('api.forums.replies.destroy', $reply));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_reply_api_destroy()
   {
      $reply = $this->replies->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.forums.replies.destroy', $reply));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_reply_api_destroy()
   {
      $reply = $this->replies->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.forums.replies.destroy', $reply));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Reply #'. $reply->id .' has been deleted'
      ]);
   }
}