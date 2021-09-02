<?php

namespace AndrykVP\Rancor\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Models\Category;
use AndrykVP\Rancor\Forums\Models\Discussion;
use AndrykVP\Rancor\Forums\Models\Group;
use AndrykVP\Rancor\Forums\Models\Reply;
use App\Models\User;

class AdminForumTest extends TestCase
{
   use RefreshDatabase;

   protected $groups, $admin, $categories, $visible_board, $invisible_board, $visible_discussion, $invisible_discussion, $editable_reply, $uneditable_reply;

   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start with empty forums
      $this->assertCount(0, Board::all());
      $this->assertCount(0, Category::all());
      $this->assertCount(0, Discussion::all());
      $this->assertCount(0, Group::all());
      $this->assertCount(0, Reply::all());

      // Initialize Forums
      $this->groups = Group::factory()->count(2)->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
      $member = User::factory()->hasAttached($this->groups->first())->create();
      $this->categories = Category::factory()->count(2)->create();
      $this->visible_board = Board::factory()->for($this->categories->first())->hasAttached($this->groups->first())->create();
      $this->invisible_board = Board::factory()->for($this->categories->last())->hasAttached($this->groups->last())->create();
      $this->visible_discussion = Discussion::factory()->for($this->admin, 'author')->for($this->visible_board)->create();
      $this->invisible_discussion = Discussion::factory()->for($member, 'author')->for($this->invisible_board)->create();
      $this->editable_reply = Reply::factory()->for($this->admin, 'author')->for($this->visible_discussion)->create();
      $this->uneditable_reply = Reply::factory()->for($member, 'author')->for($this->invisible_discussion)->create();
   }

   /** @test */
   function admin_can_access_forum_index()
   {      
      // Make sure user can see forum index
      $response = $this->actingAs($this->admin)->get(route('forums.index'));
      $response->assertSuccessful();
      $response->assertSee($this->categories->first()->name);
      $response->assertSee($this->visible_board->name);
      $response->assertSee($this->categories->last()->name);
      $response->assertSee($this->invisible_board->name);
   }

   /** @test */
   function admin_can_access_visible_forum_category()
   {
      $response = $this->actingAs($this->admin)->get(route('forums.category', $this->categories->first()));
      $response->assertSuccessful();
      $response->assertSee($this->visible_board->name);
   }

   /** @test */
   function admin_can_access_invisible_forum_category()
   {
      $response = $this->actingAs($this->admin)->get(route('forums.category', $this->categories->last()));
      $response->assertSuccessful();
      $response->assertSee($this->invisible_board->name);
   }

   /** @test */
   function admin_can_access_visible_forum_board()
   {
      $response = $this->actingAs($this->admin)->get(route('forums.board', ['category' => $this->categories->first(), 'board' => $this->visible_board]));
      $response->assertSuccessful();
      $response->assertSee($this->visible_discussion->name);
      $response->assertSee('New Discussion');
      $response->assertSee('Edit Board');
      $response->assertSee('Delete Board');
   }

   /** @test */
   function admin_can_access_invisible_forum_board()
   {
      $response = $this->actingAs($this->admin)->get(route('forums.board', ['category' => $this->categories->last(), 'board' => $this->invisible_board]));
      $response->assertSuccessful();
   }

   /** @test */
   function admin_can_access_visible_forum_discussion()
   {
      $response = $this->actingAs($this->admin)->get(route('forums.discussion', ['category' => $this->categories->first(), 'board' => $this->visible_board, 'discussion' => $this->visible_discussion]));
      $response->assertSuccessful();
      $response->assertSee('Edit Discussion');
      $response->assertSee('Delete Discussion');
      $response->assertSee('New Reply');
      $response->assertSee($this->editable_reply->body);
   }

   /** @test */
   function admin_can_access_invisible_forum_discussion()
   {
      $response = $this->actingAs($this->admin)->get(route('forums.discussion', ['category' => $this->categories->last(), 'board' => $this->invisible_board, 'discussion' => $this->invisible_discussion]));
      $response->assertSuccessful();
      $response->assertSee('Edit Discussion');
      $response->assertSee('Delete Discussion');
      $response->assertSee('New Reply');
   }

   /** @test */
   function admin_can_edit_editable_forum_reply()
   {
      $response = $this->actingAs($this->admin)->get(route('forums.replies.edit', $this->editable_reply));
      $response->assertSuccessful();
      $response->assertSee('Edit Reply');
   }

   /** @test */
   function admin_can_edit_uneditable_forum_reply()
   {
      $response = $this->actingAs($this->admin)->get(route('forums.replies.edit', $this->uneditable_reply));
      $response->assertSuccessful();
      $response->assertSee('Edit Reply');
   }
}