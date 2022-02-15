<?php

namespace Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Tests\TestCase;
use Rancor\Holocron\Models\Collection;
use App\Models\User;

class CollectionWebTest extends TestCase
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
   function guest_cannot_access_collection_index()
   {
      $response = $this->get(route('admin.collections.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_collection_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.collections.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_collection_index()
   {
      $collection = $this->collections->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.collections.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($collection->id)
               ->assertSee($collection->name);
   }

   /** @test */
   function guest_cannot_access_collection_show()
   {
      $collection = $this->collections->random();
      $response = $this->get(route('admin.collections.show', $collection));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_collection_show()
   {
      $collection = $this->collections->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.collections.show', $collection));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_collection_show()
   {
      $collection = $this->collections->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.collections.show', $collection));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.collection')
               ->assertSee($collection->id)
               ->assertSee($collection->name)
               ->assertSee($collection->slug)
               ->assertSee($collection->description);
   }

   /** @test */
   function guest_cannot_access_collection_create()
   {
      $response = $this->get(route('admin.collections.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_collection_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.collections.create'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_collection_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.collections.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_collection_store()
   {
      $response = $this->post(route('admin.collections.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_collection_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.collections.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_collection_store()
   {
      $collection = Collection::factory()->make(['category_id' => 1]);
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.collections.store'), $collection->toArray());
      $response->assertRedirect(route('admin.collections.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Collection',
                     'name' => $collection->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_collection_edit()
   {
      $collection = $this->collections->random();
      $response = $this->get(route('admin.collections.edit', $collection));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_collection_edit()
   {
      $collection = $this->collections->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.collections.edit', $collection));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_collection_edit()
   {
      $collection = $this->collections->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.collections.edit', $collection));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($collection->id)
               ->assertSee($collection->name)
               ->assertSee($collection->slug)
               ->assertSee($collection->description);
   }

   /** @test */
   function guest_cannot_access_collection_update()
   {
      $collection = $this->collections->random();
      $response = $this->patch(route('admin.collections.update', $collection), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_collection_update()
   {
      $collection = $this->collections->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.collections.update', $collection), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_collection_update()
   {
      $collection = $this->collections->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.collections.update', $collection), [
                     'id' => $collection->id,
                     'name' => 'Updated Collection',
                     'slug' => 'some-slug',
                     'description' => 'Updated Collection Description',
                  ]);
      $response->assertRedirect(route('admin.collections.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Collection',
                     'name' => 'Updated Collection',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_collection_destroy()
   {
      $collection = $this->collections->random();
      $response = $this->delete(route('admin.collections.destroy', $collection));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_collection_destroy()
   {
      $collection = $this->collections->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.collections.destroy', $collection));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_collection_destroy()
   {
      $collection = $this->collections->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.collections.destroy', $collection));
      $response->assertRedirect(route('admin.collections.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Collection',
                     'name' => $collection->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_collection_search()
   {
      $response = $this->post(route('admin.collections.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_collection_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.collections.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_collection_search()
   {
      $collection = $this->collections->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.collections.search', [
                     'attribute' => 'name',
                     'value' => $collection->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($collection->id)
               ->assertSee($collection->name);
   }
}