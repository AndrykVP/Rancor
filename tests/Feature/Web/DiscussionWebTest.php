<?php

namespace AndrykVP\Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Models\Discussion;
use AndrykVP\Rancor\Forums\Models\Group;
use App\Models\User;

class DiscussionWebTest extends TestCase
{
   use RefreshDatabase;

   protected $discussions, $user, $member, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Discussions
      $this->assertDatabaseCount('forum_discussions', 0);

      // Initialize Test DB
      $group = Group::factory()->create();
      $this->discussions = Discussion::factory()
                     ->for(Board::factory()->forCategory()->hasAttached($group))
                     ->forAuthor()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->member = User::factory()->hasAttached($group)->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_discussion_index()
   {
      $response = $this->get(route('admin.discussions.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_discussion_index()
   {
      $response = $this->actingAs($this->user)
      // ->withoutExceptionHandling()
                  ->get(route('admin.discussions.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_discussion_index()
   {
      $discussion = $this->discussions->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.discussions.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($discussion->id)
               ->assertSee($discussion->name);
   }

   /** @test */
   function guest_cannot_access_discussion_show()
   {
      $discussion = $this->discussions->random();
      $response = $this->get(route('admin.discussions.show', $discussion));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_discussion_show()
   {
      $discussion = $this->discussions->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.discussions.show', $discussion));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_discussion_show()
   {
      $discussion = $this->discussions->random()->load('board');
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.discussions.show', $discussion));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.discussion')
               ->assertSee($discussion->id)
               ->assertSee($discussion->name)
               ->assertSee($discussion->board->name);
   }

   /** @test */
   function guest_cannot_access_discussion_create()
   {
      $response = $this->get(route('forums.discussions.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_discussion_create()
   {
      $response = $this->actingAs($this->user)
               ->get(route('forums.discussions.create', ['board' => 1]));
      $response->assertStatus(403);
   }

   /** @test */
   function member_can_access_discussion_create()
   {
      $response = $this->actingAs($this->member)
                  ->get(route('forums.discussions.create', ['board' => 1]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::create.discussion');
   }

   /** @test */
   function admin_can_access_discussion_create()
   {
      $response = $this->actingAs($this->admin)
      ->withoutExceptionHandling()
                  ->get(route('forums.discussions.create', ['board' => 1]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::create.discussion');
   }

   /** @test */
   function guest_cannot_access_discussion_store()
   {
      $response = $this->post(route('forums.discussions.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_discussion_store()
   {
      $discussion = Discussion::factory()->make([
         'board_id' => 1,
         'body' => 'Reply body: Lorem Ipsum',
      ]);
      $response = $this->actingAs($this->user)
                  ->post(route('forums.discussions.store'), $discussion->toArray());
      $response->assertStatus(403);
   }

   /** @test */
   function member_can_access_discussion_store()
   {
      $discussion = Discussion::factory()->make([
         'board_id' => 1,
         'body' => 'Reply body: Lorem Ipsum',
      ]);
      $response = $this->actingAs($this->admin)
                  ->post(route('forums.discussions.store'), $discussion->toArray());
      $response->assertRedirect(route('forums.discussion', [
         'category' => $discussion->board->category->slug,
         'board' => $discussion->board->slug,
         'discussion' => 4
      ]))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Discussion',
                     'name' => $discussion->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function admin_can_access_discussion_store()
   {
      $discussion = Discussion::factory()->make([
         'board_id' => 1,
         'body' => 'Reply body: Lorem Ipsum',
      ]);
      $response = $this->actingAs($this->admin)
                  ->post(route('forums.discussions.store'), $discussion->toArray());
      $response->assertRedirect(route('forums.discussion', [
         'category' => $discussion->board->category->slug,
         'board' => $discussion->board->slug,
         'discussion' => 4
      ]))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Discussion',
                     'name' => $discussion->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_discussion_edit()
   {
      $discussion = $this->discussions->random();
      $response = $this->get(route('admin.discussions.edit', $discussion));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_discussion_edit()
   {
      $discussion = $this->discussions->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.discussions.edit', $discussion));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_discussion_edit()
   {
      $discussion = $this->discussions->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.discussions.edit', $discussion));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($discussion->id)
               ->assertSee($discussion->name);
   }

   /** @test */
   function guest_cannot_access_discussion_update()
   {
      $discussion = $this->discussions->random();
      $response = $this->patch(route('admin.discussions.update', $discussion), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_discussion_update()
   {
      $discussion = $this->discussions->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.discussions.update', $discussion), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_discussion_update()
   {
      $discussion = $this->discussions->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.discussions.update', $discussion), [
                     'id' => $discussion->id,
                     'name' => 'Updated Discussion',
                     'is_sticky' => true,
                     'is_locked' => true,
                     'board_id' => 1,
                  ]);
      $response->assertRedirect(route('admin.discussions.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Discussion',
                     'name' => 'Updated Discussion',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_discussion_destroy()
   {
      $discussion = $this->discussions->random();
      $response = $this->delete(route('admin.discussions.destroy', $discussion));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_discussion_destroy()
   {
      $discussion = $this->discussions->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.discussions.destroy', $discussion));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_discussion_destroy()
   {
      $discussion = $this->discussions->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.discussions.destroy', $discussion));
      $response->assertRedirect(route('admin.discussions.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Discussion',
                     'name' => $discussion->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_discussion_search()
   {
      $response = $this->post(route('admin.discussions.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_discussion_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.discussions.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_discussion_search()
   {
      $discussion = $this->discussions->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.discussions.search', [
                     'attribute' => 'name',
                     'value' => $discussion->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($discussion->id)
               ->assertSee($discussion->name);
   }
}