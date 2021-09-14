<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Forums\Models\Board;
use App\Models\User;

class BoardAPITest extends TestCase
{
   use RefreshDatabase;

   protected $boards, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without boards
      $this->assertDatabaseCount('forum_boards', 0);

      // Initialize Test DB
      $this->boards = Board::factory()
                     ->forCategory()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_board_api_index()
   {
      $response = $this->getJson(route('api.forums.boards.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_board_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.forums.boards.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_board_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.forums.boards.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_board_api_show()
   {
      $board = $this->boards->random();
      $response = $this->getJson(route('api.forums.boards.show', $board));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_board_api_show()
   {
      $board = $this->boards->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.forums.boards.show', $board));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_board_api_show()
   {
      $board = $this->boards->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.forums.boards.show', $board));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $board->id,
            'name' => $board->name,
            'description' => $board->description,
            'slug' => $board->slug,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_board_api_store()
   {
      $response = $this->postJson(route('api.forums.boards.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_board_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.forums.boards.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_board_api_store()
   {
      $board = Board::factory()->make(['category_id' => 1]);
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.forums.boards.store'), $board->toArray());
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Board "'. $board->name .'" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_board_api_update()
   {
      $board = $this->boards->random();
      $response = $this->patchJson(route('api.forums.boards.update', $board), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_board_api_update()
   {
      $board = $this->boards->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.forums.boards.update', $board), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_board_api_update()
   {
      $board = $this->boards->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.forums.boards.update', $board), [
                     'id' => $board->id,
                     'name' => 'Updated Board',
                     'description' => 'Updated description',
                     'slug' => 'updated-Board',
                     'category_id' => $board->category_id,
                     'groups' => [],
                     'lineup' => 1,
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Board "Updated Board" has been updated'
      ]);
   }

   /** @test */
   function guest_cannot_access_board_api_destroy()
   {
      $board = $this->boards->random();
      $response = $this->deleteJson(route('api.forums.boards.destroy', $board));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_board_api_destroy()
   {
      $board = $this->boards->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.forums.boards.destroy', $board));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_board_api_destroy()
   {
      $board = $this->boards->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.forums.boards.destroy', $board));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Board "'. $board->name .'" has been deleted'
      ]);
   }

   /** @test */
   function guest_cannot_access_board_api_search()
   {
      $response = $this->postJson(route('api.forums.boards.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_board_api_search()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.forums.boards.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_board_api_search()
   {
      $board = $this->boards->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.forums.boards.search', [
                     'attribute' => 'name',
                     'value' => $board->name,
                  ]));
      $response->assertSuccessful()->assertJsonFragment(['id' => $board->id]);
   }
}