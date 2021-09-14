<?php

namespace AndrykVP\Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Forums\Models\Board;
use App\Models\User;

class BoardWebTest extends TestCase
{
   use RefreshDatabase;

   protected $boards, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Boards
      $this->assertDatabaseCount('forum_boards', 0);

      // Initialize Test DB
      $this->boards = Board::factory()
                     ->forCategory()
                     ->hasGroups()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_board_index()
   {
      $response = $this->get(route('admin.boards.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_board_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.boards.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_board_index()
   {
      $board = $this->boards->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.boards.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($board->id)
               ->assertSee($board->name);
   }

   /** @test */
   function guest_cannot_access_board_show()
   {
      $board = $this->boards->random();
      $response = $this->get(route('admin.boards.show', $board));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_board_show()
   {
      $board = $this->boards->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.boards.show', $board));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_board_show()
   {
      $board = $this->boards->random()->load('category');
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.boards.show', $board));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.board')
               ->assertSee($board->id)
               ->assertSee($board->name)
               ->assertSee($board->slug)
               ->assertSee($board->description)
               ->assertSee($board->category->name);
   }

   /** @test */
   function guest_cannot_access_board_create()
   {
      $response = $this->get(route('admin.boards.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_board_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.boards.create'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_board_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.boards.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_board_store()
   {
      $response = $this->post(route('admin.boards.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_board_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.boards.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_board_store()
   {
      $board = Board::factory()->make(['category_id' => 1]);
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.boards.store'), $board->toArray());
      $response->assertRedirect(route('admin.boards.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Board',
                     'name' => $board->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_board_edit()
   {
      $board = $this->boards->random();
      $response = $this->get(route('admin.boards.edit', $board));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_board_edit()
   {
      $board = $this->boards->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.boards.edit', $board));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_board_edit()
   {
      $board = $this->boards->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.boards.edit', $board));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($board->id)
               ->assertSee($board->name)
               ->assertSee($board->slug)
               ->assertSee($board->description)
               ->assertSee($board->lineup);
   }

   /** @test */
   function guest_cannot_access_board_update()
   {
      $board = $this->boards->random();
      $response = $this->patch(route('admin.boards.update', $board), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_board_update()
   {
      $board = $this->boards->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.boards.update', $board), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_board_update()
   {
      $board = $this->boards->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.boards.update', $board), [
                     'id' => $board->id,
                     'name' => 'Updated Board',
                     'slug' => 'some-slug',
                     'description' => 'Updated Board Description',
                     'category_id' => 1,
                     'lineup' => 2,
                  ]);
      $response->assertRedirect(route('admin.boards.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Board',
                     'name' => 'Updated Board',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_board_destroy()
   {
      $board = $this->boards->random();
      $response = $this->delete(route('admin.boards.destroy', $board));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_board_destroy()
   {
      $board = $this->boards->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.boards.destroy', $board));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_board_destroy()
   {
      $board = $this->boards->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.boards.destroy', $board));
      $response->assertRedirect(route('admin.boards.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Board',
                     'name' => $board->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_board_search()
   {
      $response = $this->post(route('admin.boards.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_board_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.boards.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_board_search()
   {
      $board = $this->boards->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.boards.search', [
                     'attribute' => 'name',
                     'value' => $board->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($board->id)
               ->assertSee($board->name);
   }
}