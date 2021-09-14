<?php

namespace AndrykVP\Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Structure\Models\Department;
use AndrykVP\Rancor\Structure\Models\Rank;
use App\Models\User;

class RankWebTest extends TestCase
{
   use RefreshDatabase;

   protected $ranks, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Ranks
      $this->assertDatabaseCount('structure_ranks', 0);

      // Initialize Test DB
      $this->ranks = Rank::factory()
                     ->for(Department::factory()->forFaction())
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_rank_index()
   {
      $response = $this->get(route('admin.ranks.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_rank_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.ranks.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_rank_index()
   {
      $rank = $this->ranks->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.ranks.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($rank->id)
               ->assertSee($rank->name);
   }

   /** @test */
   function guest_cannot_access_rank_show()
   {
      $rank = $this->ranks->random();
      $response = $this->get(route('admin.ranks.show', $rank));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_rank_show()
   {
      $rank = $this->ranks->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.ranks.show', $rank));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_rank_show()
   {
      $rank = $this->ranks->random()->load('department.faction');
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.ranks.show', $rank));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.rank')
               ->assertSee($rank->id)
               ->assertSee($rank->name)
               ->assertSee($rank->description)
               ->assertSee($rank->color)
               ->assertSee($rank->level)
               ->assertSee($rank->department->name)
               ->assertSee($rank->department->faction->name);
   }

   /** @test */
   function guest_cannot_access_rank_create()
   {
      $response = $this->get(route('admin.ranks.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_rank_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.ranks.create'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_rank_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.ranks.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_rank_store()
   {
      $response = $this->post(route('admin.ranks.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_rank_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.ranks.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_rank_store()
   {
      $rank = Rank::factory()->make(['department_id' => 1]);
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.ranks.store'), $rank->toArray());
      $response->assertRedirect(route('admin.ranks.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Rank',
                     'name' => $rank->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_rank_edit()
   {
      $rank = $this->ranks->random();
      $response = $this->get(route('admin.ranks.edit', $rank));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_rank_edit()
   {
      $rank = $this->ranks->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.ranks.edit', $rank));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_rank_edit()
   {
      $rank = $this->ranks->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.ranks.edit', $rank));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($rank->id)
               ->assertSee($rank->name)
               ->assertSee($rank->description)
               ->assertSee($rank->color)
               ->assertSee($rank->level);
   }

   /** @test */
   function guest_cannot_access_rank_update()
   {
      $rank = $this->ranks->random();
      $response = $this->patch(route('admin.ranks.update', $rank), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_rank_update()
   {
      $rank = $this->ranks->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.ranks.update', $rank), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_rank_update()
   {
      $rank = $this->ranks->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.ranks.update', $rank), [
                     'id' => $rank->id,
                     'name' => 'Updated Rank',
                     'description' => 'Updated Rank Description',
                     'color' => '#123456',
                     'level' => 1,
                     'department_id' => 1,
                  ]);
      $response->assertRedirect(route('admin.ranks.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Rank',
                     'name' => 'Updated Rank',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_rank_destroy()
   {
      $rank = $this->ranks->random();
      $response = $this->delete(route('admin.ranks.destroy', $rank));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_rank_destroy()
   {
      $rank = $this->ranks->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.ranks.destroy', $rank));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_rank_destroy()
   {
      $rank = $this->ranks->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.ranks.destroy', $rank));
      $response->assertRedirect(route('admin.ranks.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Rank',
                     'name' => $rank->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_rank_search()
   {
      $response = $this->post(route('admin.ranks.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_rank_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.ranks.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_rank_search()
   {
      $rank = $this->ranks->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.ranks.search', [
                     'attribute' => 'name',
                     'value' => $rank->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($rank->id)
               ->assertSee($rank->name);
   }
}