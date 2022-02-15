<?php

namespace Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Tests\TestCase;
use Rancor\Structure\Models\AwardType;
use App\Models\User;

class AwardTypeWebTest extends TestCase
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
   function guest_cannot_access_award_type_index()
   {
      $response = $this->get(route('admin.awardtypes.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_type_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.awardtypes.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_type_index()
   {
      $awardtype = $this->awardtypes->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.awardtypes.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($awardtype->id)
               ->assertSee($awardtype->name);
   }

   /** @test */
   function guest_cannot_access_award_type_show()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->get(route('admin.awardtypes.show', $awardtype));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_type_show()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.awardtypes.show', $awardtype));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_type_show()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.awardtypes.show', $awardtype));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.awardtype')
               ->assertSee($awardtype->id)
               ->assertSee($awardtype->name)
               ->assertSee($awardtype->description);
   }

   /** @test */
   function guest_cannot_access_award_type_create()
   {
      $response = $this->get(route('admin.awardtypes.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_type_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.awardtypes.create'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_type_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.awardtypes.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_award_type_store()
   {
      $response = $this->post(route('admin.awardtypes.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_type_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.awardtypes.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_type_store()
   {
      $awardtype = AwardType::factory()->make(['type_id' => 1]);
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.awardtypes.store'), $awardtype->toArray());
      $response->assertRedirect(route('admin.awardtypes.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Award Type',
                     'name' => $awardtype->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_award_type_edit()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->get(route('admin.awardtypes.edit', $awardtype));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_type_edit()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.awardtypes.edit', $awardtype));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_type_edit()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.awardtypes.edit', $awardtype));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($awardtype->id)
               ->assertSee($awardtype->name)
               ->assertSee($awardtype->description);
   }

   /** @test */
   function guest_cannot_access_award_type_update()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->patch(route('admin.awardtypes.update', $awardtype), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_type_update()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.awardtypes.update', $awardtype), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_type_update()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.awardtypes.update', $awardtype), [
                     'id' => $awardtype->id,
                     'name' => 'Updated AwardType',
                     'description' => 'Updated AwardType Description',
                  ]);
      $response->assertRedirect(route('admin.awardtypes.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Award Type',
                     'name' => 'Updated AwardType',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_award_type_destroy()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->delete(route('admin.awardtypes.destroy', $awardtype));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_type_destroy()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.awardtypes.destroy', $awardtype));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_type_destroy()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.awardtypes.destroy', $awardtype));
      $response->assertRedirect(route('admin.awardtypes.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Award Type',
                     'name' => $awardtype->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_award_type_search()
   {
      $response = $this->post(route('admin.awardtypes.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_type_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.awardtypes.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_type_search()
   {
      $awardtype = $this->awardtypes->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.awardtypes.search', [
                     'attribute' => 'name',
                     'value' => $awardtype->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($awardtype->id)
               ->assertSee($awardtype->name);
   }
}