<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Scanner\Models\TerritoryType;
use App\Models\User;

class TerritoryTypeAPITest extends TestCase
{
   use RefreshDatabase;

   protected $territorytypes, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without TerritoryTypes
      $this->assertDatabaseCount('scanner_territory_types', 0);

      // Initialize Test DB
      $this->territorytypes = TerritoryType::factory()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_territory_type_api_index()
   {
      $response = $this->getJson(route('api.scanner.territorytypes.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_territory_type_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.scanner.territorytypes.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_territory_type_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.scanner.territorytypes.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_territory_type_api_show()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->getJson(route('api.scanner.territorytypes.show', $territorytype));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_territory_type_api_show()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.scanner.territorytypes.show', $territorytype));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_territory_type_api_show()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.scanner.territorytypes.show', $territorytype));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $territorytype->id,
            'name' => $territorytype->name,
            'image' => $territorytype->image,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_territory_type_api_store()
   {
      $response = $this->postJson(route('api.scanner.territorytypes.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_territory_type_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.scanner.territorytypes.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_territory_type_api_store()
   {
      $territorytype = TerritoryType::factory()->make();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.scanner.territorytypes.store'), $territorytype->toArray());
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Territory Type "'. $territorytype->name .'" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_territory_type_api_update()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->patchJson(route('api.scanner.territorytypes.update', $territorytype), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_territory_type_api_update()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.scanner.territorytypes.update', $territorytype), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_territory_type_api_update()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->withoutExceptionHandling()
                  ->patchJson(route('api.scanner.territorytypes.update', $territorytype), [
                     'id' => $territorytype->id,
                     'name' => 'Updated Type',
                     'image' => 'http://www.example.com/image.png',
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Territory Type "Updated Type" has been updated'
      ]);
   }

   /** @test */
   function guest_cannot_access_territory_type_api_destroy()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->deleteJson(route('api.scanner.territorytypes.destroy', $territorytype));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_territory_type_api_destroy()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.scanner.territorytypes.destroy', $territorytype));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_territory_type_api_destroy()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.scanner.territorytypes.destroy', $territorytype));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Territory Type "'. $territorytype->name .'" has been deleted'
      ]);
   }

   /** @test */
   function guest_cannot_access_territory_type_api_search()
   {
      $response = $this->postJson(route('api.scanner.territorytypes.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_territory_type_api_search()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.scanner.territorytypes.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_territory_type_api_search()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->admin, 'api')
      ->withoutExceptionHandling()
                  ->postJson(route('api.scanner.territorytypes.search', [
                     'attribute' => 'name',
                     'value' => $territorytype->name,
                  ]));
      $response->assertSuccessful()->assertJsonFragment(['id' => $territorytype->id]);
   }
}