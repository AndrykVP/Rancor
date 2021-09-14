<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Models\Discussion;
use App\Models\User;

class DiscussionAPITest extends TestCase
{
   use RefreshDatabase;

   protected $discussions, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Discussions
      $this->assertDatabaseCount('forum_discussions', 0);

      // Initialize Test DB
      $this->discussions = Discussion::factory()
                     ->for(Board::factory()->forCategory())
                     ->forAuthor()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_discussion_api_index()
   {
      $response = $this->getJson(route('api.forums.discussions.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_discussion_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.forums.discussions.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_discussion_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.forums.discussions.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_discussion_api_show()
   {
      $discussion = $this->discussions->random();
      $response = $this->getJson(route('api.forums.discussions.show', $discussion));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_discussion_api_show()
   {
      $discussion = $this->discussions->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.forums.discussions.show', $discussion));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_discussion_api_show()
   {
      $discussion = $this->discussions->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.forums.discussions.show', $discussion));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $discussion->id,
            'name' => $discussion->name,
            'is_sticky' => $discussion->is_sticky,
            'is_locked' => $discussion->is_locked,
            'views' => $discussion->views,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_discussion_api_store()
   {
      $response = $this->postJson(route('api.forums.discussions.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_discussion_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.forums.discussions.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_discussion_api_store()
   {
      $discussion = Discussion::factory()->make(['board_id' => 1]);
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.forums.discussions.store'), array_merge($discussion->toArray(), [
                     'body' => 'Example Discussion Body'
                  ]));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Discussion "'. $discussion->name .'" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_discussion_api_update()
   {
      $discussion = $this->discussions->random();
      $response = $this->patchJson(route('api.forums.discussions.update', $discussion), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_discussion_api_update()
   {
      $discussion = $this->discussions->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.forums.discussions.update', $discussion), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_discussion_api_update()
   {
      $discussion = $this->discussions->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.forums.discussions.update', $discussion), [
                     'id' => $discussion->id,
                     'name' => 'Updated Discussion',
                     'is_sticky' => true,
                     'is_locked' => false,
                     'board_id' => $discussion->board_id,
                     'author_id' => $this->admin->id
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Discussion "Updated Discussion" has been updated'
      ]);
   }

   /** @test */
   function guest_cannot_access_discussion_api_destroy()
   {
      $discussion = $this->discussions->random();
      $response = $this->deleteJson(route('api.forums.discussions.destroy', $discussion));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_discussion_api_destroy()
   {
      $discussion = $this->discussions->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.forums.discussions.destroy', $discussion));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_discussion_api_destroy()
   {
      $discussion = $this->discussions->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.forums.discussions.destroy', $discussion));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Discussion "'. $discussion->name .'" has been deleted'
      ]);
   }

   /** @test */
   function guest_cannot_access_discussion_api_search()
   {
      $response = $this->postJson(route('api.forums.discussions.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_discussion_api_search()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.forums.discussions.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_discussion_api_search()
   {
      $discussion = $this->discussions->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.forums.discussions.search', [
                     'attribute' => 'name',
                     'value' => $discussion->name,
                  ]));
      $response->assertSuccessful()->assertJsonFragment(['id' => $discussion->id]);
   }
}