<?php

namespace AndrykVP\Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Models\Discussion;
use AndrykVP\Rancor\Forums\Models\Group;
use AndrykVP\Rancor\Forums\Models\Reply;
use App\Models\User;

class ReplyWebTest extends TestCase
{
   use RefreshDatabase;

   protected $replies, $user, $member, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Replies
      $this->assertDatabaseCount('forum_replies', 0);

      // Initialize Test DB
      $group = Group::factory()->create();
      $this->replies = Reply::factory()
                     ->for(Discussion::factory()
                        ->for(Board::factory()->forCategory()->hasAttached($group)
                        )
                        ->forAuthor()
                        ->locked(false)
                     )
                     ->forAuthor()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->member = User::factory()->hasAttached($group)->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }
   
   /** @test */
   function guest_cannot_access_reply_create()
   {
      $response = $this->get(route('forums.replies.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_reply_create()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('forums.replies.create', ['discussion' => 1]));
      $response->assertStatus(403);
   }

   /** @test */
   function member_can_access_reply_create()
   {
      $response = $this->actingAs($this->member)
                  ->get(route('forums.replies.create', ['discussion' => 1]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::create.reply');
   }

   /** @test */
   function admin_can_access_reply_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('forums.replies.create', ['discussion' => 1]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::create.reply');
   }

   /** @test */
   function guest_cannot_access_reply_store()
   {
      $response = $this->post(route('forums.replies.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_reply_store()
   {
      $reply = Reply::factory()->make(['discussion_id' => 1]);
      $response = $this->actingAs($this->user)
                  ->post(route('forums.replies.store'), $reply->toArray());
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_reply_store()
   {
      $reply = Reply::factory()->make(['discussion_id' => 1]);
      $response = $this->actingAs($this->admin)
                  ->post(route('forums.replies.store'), $reply->toArray());
      $response->assertRedirect(route('forums.discussion', [
         'category' => $reply->discussion->board->category->slug,
         'board' => $reply->discussion->board->slug,
         'discussion' => $reply->discussion,
      ]))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Reply',
                     'id' => 4,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_reply_edit()
   {
      $reply = $this->replies->random();
      $response = $this->get(route('forums.replies.edit', $reply));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_reply_edit()
   {
      $reply = $this->replies->random();
      $response = $this->actingAs($this->user)
                  ->get(route('forums.replies.edit', $reply));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_reply_edit()
   {
      $reply = $this->replies->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('forums.replies.edit', $reply));
      $response->assertSuccessful()
               ->assertViewIs('rancor::edit.reply')
               ->assertSee($reply->id)
               ->assertSee($reply->body);
   }

   /** @test */
   function guest_cannot_access_reply_update()
   {
      $reply = $this->replies->random();
      $response = $this->patch(route('forums.replies.update', $reply), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_reply_update()
   {
      $reply = $this->replies->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('forums.replies.update', $reply), [
                     'id' => $reply->id,
                     'body' => 'Updated Reply',
                     'discussion_id' => 1,
                  ]);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_reply_update()
   {
      $reply = $this->replies->random()->load('discussion.board.category');
      $response = $this->actingAs($this->admin)
                  ->patch(route('forums.replies.update', $reply), [
                     'id' => $reply->id,
                     'body' => 'Updated Reply',
                     'discussion_id' => 1,
                  ]);
      $response->assertRedirect(route('forums.discussion', [
         'category' => $reply->discussion->board->category->slug,
         'board' => $reply->discussion->board->slug,
         'discussion' => $reply->discussion,
         'page' => 1
         ]))
         ->assertSessionHas('alert', [
            'message' => [
               'model' => 'Reply',
               'id' => $reply->id,
               'action' => 'updated',
            ]
         ]);
   }
   
   /** @test */
   function guest_cannot_access_reply_destroy()
   {
      $reply = $this->replies->random();
      $response = $this->delete(route('forums.replies.destroy', $reply));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_reply_destroy()
   {
      $reply = $this->replies->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('forums.replies.destroy', $reply));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_reply_destroy()
   {
      $reply = $this->replies->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('forums.replies.destroy', $reply));
      $response->assertRedirect(route('forums.discussion', [
         'category' => $reply->discussion->board->category->slug,
         'board' => $reply->discussion->board->slug,
         'discussion' => $reply->discussion
         ]))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Reply',
                     'id' => $reply->id,
                     'action' => 'deleted',
                  ]
               ]);
   }
}