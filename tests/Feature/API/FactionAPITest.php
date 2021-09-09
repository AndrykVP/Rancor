<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Structure\Models\Faction;
use App\Models\User;

class FactionAPITest extends TestCase
{
   use RefreshDatabase;

   protected $factions, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Factions
      $this->assertDatabaseCount('structure_factions', 0);

      // Initialize Test DB
      $this->factions = Faction::factory()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_faction_api_index()
   {
      $response = $this->getJson(route('api.structure.factions.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_faction_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.structure.factions.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_faction_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.structure.factions.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_faction_api_show()
   {
      $faction = $this->factions->random();
      $response = $this->getJson(route('api.structure.factions.show', $faction));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_faction_api_show()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.structure.factions.show', $faction));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_faction_api_show()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.structure.factions.show', $faction));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $faction->id,
            'name' => $faction->name,
            'description' => $faction->description,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_faction_api_store()
   {
      $response = $this->postJson(route('api.structure.factions.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_faction_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.structure.factions.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_faction_api_store()
   {
      $faction = Faction::factory()->make();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.structure.factions.store'), $faction->toArray());
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Faction "'. $faction->name .'" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_faction_api_update()
   {
      $faction = $this->factions->random();
      $response = $this->patchJson(route('api.structure.factions.update', $faction), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_faction_api_update()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.structure.factions.update', $faction), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_faction_api_update()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.structure.factions.update', $faction), [
                     'id' => $faction->id,
                     'name' => 'Updated Faction',
                     'description' => 'Updated Faction Description',
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Faction "Updated Faction" has been updated'
      ]);
   }

   /** @test */
   function guest_cannot_access_faction_api_destroy()
   {
      $faction = $this->factions->random();
      $response = $this->deleteJson(route('api.structure.factions.destroy', $faction));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_faction_api_destroy()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.structure.factions.destroy', $faction));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_faction_api_destroy()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.structure.factions.destroy', $faction));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Faction "'. $faction->name .'" has been deleted'
      ]);
   }

   /** @test */
   function guest_cannot_access_faction_api_search()
   {
      $response = $this->postJson(route('api.structure.factions.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_faction_api_search()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.structure.factions.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_faction_api_search()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.structure.factions.search', [
                     'attribute' => 'name',
                     'value' => $faction->name,
                  ]));
      $response->assertSuccessful()->assertJsonFragment(['id' => $faction->id]);
   }
}