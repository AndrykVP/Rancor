<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Structure\Models\Award;
use App\Models\User;

class AwardAPITest extends TestCase
{
   use RefreshDatabase;

   protected $awards, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Awards
      $this->assertDatabaseCount('structure_awards', 0);

      // Initialize Test DB
      $this->awards = Award::factory()
                     ->forType()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_award_api_index()
   {
      $response = $this->getJson(route('api.structure.awards.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_award_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.structure.awards.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_award_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.structure.awards.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_award_api_show()
   {
      $award = $this->awards->random();
      $response = $this->getJson(route('api.structure.awards.show', $award));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_award_api_show()
   {
      $award = $this->awards->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.structure.awards.show', $award));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_award_api_show()
   {
      $award = $this->awards->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.structure.awards.show', $award));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $award->id,
            'name' => $award->name,
            'description' => $award->description,
            'code' => $award->code,
            'levels' => $award->levels,
            'priority' => $award->priority,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_award_api_store()
   {
      $response = $this->postJson(route('api.structure.awards.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_award_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.structure.awards.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_award_api_store()
   {
      $award = Award::factory()->make(['type_id' => 1]);
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.structure.awards.store'), $award->toArray());
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Award "'. $award->name .'" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_award_api_update()
   {
      $award = $this->awards->random();
      $response = $this->patchJson(route('api.structure.awards.update', $award), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_award_api_update()
   {
      $award = $this->awards->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.structure.awards.update', $award), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_award_api_update()
   {
      $award = $this->awards->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.structure.awards.update', $award), [
                     'id' => $award->id,
                     'name' => 'Updated Award',
                     'description' => 'Updated Award Description',
                     'type_id' => 1,
                     'code' => 'ABC',
                     'levels' => 3,
                     'priority' => 1,
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Award "Updated Award" has been updated'
      ]);
   }

   /** @test */
   function guest_cannot_access_award_api_destroy()
   {
      $award = $this->awards->random();
      $response = $this->deleteJson(route('api.structure.awards.destroy', $award));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_award_api_destroy()
   {
      $award = $this->awards->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.structure.awards.destroy', $award));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_award_api_destroy()
   {
      $award = $this->awards->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.structure.awards.destroy', $award));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Award "'. $award->name .'" has been deleted'
      ]);
   }

   /** @test */
   function guest_cannot_access_award_api_search()
   {
      $response = $this->postJson(route('api.structure.awards.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_award_api_search()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.structure.awards.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_award_api_search()
   {
      $award = $this->awards->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.structure.awards.search', [
                     'attribute' => 'name',
                     'value' => $award->name,
                  ]));
      $response->assertSuccessful()->assertJsonFragment(['id' => $award->id]);
   }
}