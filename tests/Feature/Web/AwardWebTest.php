<?php

namespace AndrykVP\Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Structure\Models\Award;
use App\Models\User;

class AwardWebTest extends TestCase
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
   function guest_cannot_access_award_index()
   {
      $response = $this->get(route('admin.awards.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.awards.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_index()
   {
      $award = $this->awards->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.awards.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($award->id)
               ->assertSee($award->name);
   }

   /** @test */
   function guest_cannot_access_award_show()
   {
      $award = $this->awards->random();
      $response = $this->get(route('admin.awards.show', $award));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_show()
   {
      $award = $this->awards->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.awards.show', $award));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_show()
   {
      $award = $this->awards->random()->load('type');
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.awards.show', $award));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.award')
               ->assertSee($award->id)
               ->assertSee($award->name)
               ->assertSee($award->description)
               ->assertSee($award->code)
               ->assertSee($award->type->name)
               ->assertSee($award->levels)
               ->assertSee($award->priority);
   }

   /** @test */
   function guest_cannot_access_award_create()
   {
      $response = $this->get(route('admin.awards.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.awards.create'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.awards.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_award_store()
   {
      $response = $this->post(route('admin.awards.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.awards.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_store()
   {
      $award = Award::factory()->make(['type_id' => 1]);
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.awards.store'), $award->toArray());
      $response->assertRedirect(route('admin.awards.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Award',
                     'name' => $award->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_award_edit()
   {
      $award = $this->awards->random();
      $response = $this->get(route('admin.awards.edit', $award));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_edit()
   {
      $award = $this->awards->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.awards.edit', $award));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_edit()
   {
      $award = $this->awards->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.awards.edit', $award));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($award->id)
               ->assertSee($award->name)
               ->assertSee($award->description)
               ->assertSee($award->code)
               ->assertSee($award->levels)
               ->assertSee($award->priority);
   }

   /** @test */
   function guest_cannot_access_award_update()
   {
      $award = $this->awards->random();
      $response = $this->patch(route('admin.awards.update', $award), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_update()
   {
      $award = $this->awards->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.awards.update', $award), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_update()
   {
      $award = $this->awards->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.awards.update', $award), [
                     'id' => $award->id,
                     'name' => 'Updated Award',
                     'description' => 'Updated Award Description',
                     'code' => 'ABCD',
                     'levels' => 7,
                     'type_id' => 1,
                     'priority' => 2,
                  ]);
      $response->assertRedirect(route('admin.awards.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Award',
                     'name' => 'Updated Award',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_award_destroy()
   {
      $award = $this->awards->random();
      $response = $this->delete(route('admin.awards.destroy', $award));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_destroy()
   {
      $award = $this->awards->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.awards.destroy', $award));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_destroy()
   {
      $award = $this->awards->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.awards.destroy', $award));
      $response->assertRedirect(route('admin.awards.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Award',
                     'name' => $award->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_award_search()
   {
      $response = $this->post(route('admin.awards.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_award_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.awards.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_award_search()
   {
      $award = $this->awards->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.awards.search', [
                     'attribute' => 'name',
                     'value' => $award->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($award->id)
               ->assertSee($award->name);
   }
}