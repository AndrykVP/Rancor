<?php

namespace Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Tests\TestCase;
use Rancor\Structure\Models\Department;
use Rancor\Structure\Models\Rank;
use App\Models\User;

class RankAPITest extends TestCase
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
   function guest_cannot_access_rank_api_index()
   {
      $response = $this->getJson(route('api.structure.ranks.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_rank_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.structure.ranks.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_rank_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.structure.ranks.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_rank_api_show()
   {
      $rank = $this->ranks->random();
      $response = $this->getJson(route('api.structure.ranks.show', $rank));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_rank_api_show()
   {
      $rank = $this->ranks->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.structure.ranks.show', $rank));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_rank_api_show()
   {
      $rank = $this->ranks->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.structure.ranks.show', $rank));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $rank->id,
            'name' => $rank->name,
            'description' => $rank->description,
            'color' => $rank->color,
            'level' => $rank->level,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_rank_api_store()
   {
      $response = $this->postJson(route('api.structure.ranks.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_rank_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.structure.ranks.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_rank_api_store()
   {
      $rank = Rank::factory()->make(['department_id' => 1]);
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.structure.ranks.store'), $rank->toArray());
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Rank "'. $rank->name .'" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_rank_api_update()
   {
      $rank = $this->ranks->random();
      $response = $this->patchJson(route('api.structure.ranks.update', $rank), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_rank_api_update()
   {
      $rank = $this->ranks->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.structure.ranks.update', $rank), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_rank_api_update()
   {
      $rank = $this->ranks->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.structure.ranks.update', $rank), [
                     'id' => $rank->id,
                     'name' => 'Updated Rank',
                     'description' => 'Updated Rank Description',
                     'color' => '#123456',
                     'level' => 1,
                     'department_id' => $rank->department_id,
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Rank "Updated Rank" has been updated'
      ]);
   }

   /** @test */
   function guest_cannot_access_rank_api_destroy()
   {
      $rank = $this->ranks->random();
      $response = $this->deleteJson(route('api.structure.ranks.destroy', $rank));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_rank_api_destroy()
   {
      $rank = $this->ranks->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.structure.ranks.destroy', $rank));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_rank_api_destroy()
   {
      $rank = $this->ranks->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.structure.ranks.destroy', $rank));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Rank "'. $rank->name .'" has been deleted'
      ]);
   }

   /** @test */
   function guest_cannot_access_rank_api_search()
   {
      $response = $this->postJson(route('api.structure.ranks.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_rank_api_search()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.structure.ranks.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_rank_api_search()
   {
      $rank = $this->ranks->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.structure.ranks.search', [
                     'attribute' => 'name',
                     'value' => $rank->name,
                  ]));
      $response->assertSuccessful()->assertJsonFragment(['id' => $rank->id]);
   }
}