<?php

namespace Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Tests\TestCase;
use Rancor\Structure\Models\AwardType;
use App\Models\User;

class AwardTypeAPITest extends TestCase
{
   use RefreshDatabase;

   protected $awardtypes, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without AwardTypes
      $this->assertDatabaseCount('structure_award_types', 0);

      // Initialize Test DB
      $this->awardtypes = AwardType::factory()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_award_type_api_index()
   {
      $response = $this->getJson(route('api.structure.awardtypes.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_award_type_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.structure.awardtypes.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_type_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.structure.awardtypes.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_award_type_api_show()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->getJson(route('api.structure.awardtypes.show', $awardtype));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_award_type_api_show()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.structure.awardtypes.show', $awardtype));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_type_api_show()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.structure.awardtypes.show', $awardtype));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $awardtype->id,
            'name' => $awardtype->name,
            'description' => $awardtype->description,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_award_type_api_store()
   {
      $response = $this->postJson(route('api.structure.awardtypes.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_award_type_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.structure.awardtypes.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_type_api_store()
   {
      $awardtype = AwardType::factory()->make();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.structure.awardtypes.store'), $awardtype->toArray());
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Award Type "'. $awardtype->name .'" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_award_type_api_update()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->patchJson(route('api.structure.awardtypes.update', $awardtype), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_award_type_api_update()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.structure.awardtypes.update', $awardtype), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_type_api_update()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.structure.awardtypes.update', $awardtype), [
                     'id' => $awardtype->id,
                     'name' => 'Updated Award Type',
                     'description' => 'Updated Award Type Description',
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Award Type "Updated Award Type" has been updated'
      ]);
   }

   /** @test */
   function guest_cannot_access_award_type_api_destroy()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->deleteJson(route('api.structure.awardtypes.destroy', $awardtype));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_award_type_api_destroy()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.structure.awardtypes.destroy', $awardtype));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_type_api_destroy()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.structure.awardtypes.destroy', $awardtype));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Award Type "'. $awardtype->name .'" has been deleted'
      ]);
   }

   /** @test */
   function guest_cannot_access_award_type_api_search()
   {
      $response = $this->postJson(route('api.structure.awardtypes.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_award_type_api_search()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.structure.awardtypes.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_type_api_search()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.structure.awardtypes.search', [
                     'attribute' => 'name',
                     'value' => $awardtype->name,
                  ]));
      $response->assertSuccessful()->assertJsonFragment(['id' => $awardtype->id]);
   }
}