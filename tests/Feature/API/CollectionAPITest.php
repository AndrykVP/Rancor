<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Holocron\Models\Collection;
use App\Models\User;

class CollectionAPITest extends TestCase
{
   use RefreshDatabase;

   protected $collections, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Collections
      $this->assertDatabaseCount('holocron_collections', 0);

      // Initialize Test DB
      $this->collections = Collection::factory()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_collection_api_index()
   {
      $response = $this->getJson(route('api.holocron.collections.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_collection_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.holocron.collections.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_collection_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.holocron.collections.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_collection_api_show()
   {
      $collection = $this->collections->random();
      $response = $this->getJson(route('api.holocron.collections.show', $collection));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_collection_api_show()
   {
      $collection = $this->collections->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.holocron.collections.show', $collection));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_collection_api_show()
   {
      $collection = $this->collections->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.holocron.collections.show', $collection));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $collection->id,
            'name' => $collection->name,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_collection_api_store()
   {
      $response = $this->postJson(route('api.holocron.collections.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_collection_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.holocron.collections.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_collection_api_store()
   {
      $collection = Collection::factory()->make();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.holocron.collections.store'), $collection->toArray());
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Collection "'. $collection->name .'" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_collection_api_update()
   {
      $collection = $this->collections->random();
      $response = $this->patchJson(route('api.holocron.collections.update', $collection), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_collection_api_update()
   {
      $collection = $this->collections->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.holocron.collections.update', $collection), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_collection_api_update()
   {
      $collection = $this->collections->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.holocron.collections.update', $collection), [
                     'id' => $collection->id,
                     'name' => 'Updated Collection',
                     'slug' => 'updated-collection',
                     'description' => 'Updated Collection Description'
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Collection "Updated Collection" has been updated'
      ]);
   }
   /** @test */
   function guest_cannot_access_collection_api_destroy()
   {
      $collection = $this->collections->random();
      $response = $this->deleteJson(route('api.holocron.collections.destroy', $collection));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_collection_api_destroy()
   {
      $collection = $this->collections->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.holocron.collections.destroy', $collection));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_collection_api_destroy()
   {
      $collection = $this->collections->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.holocron.collections.destroy', $collection));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Collection "'. $collection->name .'" has been deleted'
      ]);
   }
}