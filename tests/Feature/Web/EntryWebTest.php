<?php

namespace AndrykVP\Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Scanner\Models\Entry;
use App\Models\User;

class EntryWebTest extends TestCase
{
   use RefreshDatabase;

   protected $entries, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Entries
      $this->assertDatabaseCount('scanner_entries', 0);

      // Initialize Test DB
      $this->entries = Entry::factory()
                     ->forContributor()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_entry_index()
   {
      $response = $this->get(route('admin.entries.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_entry_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.entries.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_entry_index()
   {
      $entry = $this->entries->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.entries.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($entry->id)
               ->assertSee($entry->name);
   }

   /** @test */
   function guest_cannot_access_entry_show()
   {
      $entry = $this->entries->random();
      $response = $this->get(route('admin.entries.show', $entry));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_entry_show()
   {
      $entry = $this->entries->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.entries.show', $entry));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_entry_show()
   {
      $entry = $this->entries->random()->load('contributor');
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.entries.show', $entry));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.entries')
               ->assertSee($entry->id)
               ->assertSee($entry->entity_id)
               ->assertSee($entry->type)
               ->assertSee($entry->name)
               ->assertSee($entry->owner)
               ->assertSee($entry->contributor->name);
   }

   /** @test */
   function guest_cannot_access_entry_create()
   {
      $response = $this->get(route('admin.entries.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_entry_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.entries.create'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_entry_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.entries.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_entry_store()
   {
      $response = $this->post(route('admin.entries.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_entry_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.entries.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_entry_store()
   {
      $entry = Entry::factory()->make(['category_id' => 1]);
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.entries.store'), $entry->toArray());
      $response->assertRedirect(route('admin.entries.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Entry',
                     'name' => $entry->name,
                     'action' => 'created',
                     'id' => $entry->entity_id,
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_entry_edit()
   {
      $entry = $this->entries->random();
      $response = $this->get(route('admin.entries.edit', $entry));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_entry_edit()
   {
      $entry = $this->entries->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.entries.edit', $entry));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_entry_edit()
   {
      $entry = $this->entries->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.entries.edit', $entry));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($entry->id)
               ->assertSee($entry->entity_id)
               ->assertSee($entry->name)
               ->assertSee($entry->type)
               ->assertSee($entry->owner);
   }

   /** @test */
   function guest_cannot_access_entry_update()
   {
      $entry = $this->entries->random();
      $response = $this->patch(route('admin.entries.update', $entry), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_entry_update()
   {
      $entry = $this->entries->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.entries.update', $entry), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_entry_update()
   {
      $entry = $this->entries->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.entries.update', $entry), [
                     'id' => $entry->id,
                     'entity_id' => $entry->entity_id,
                     'name' => 'Updated Entry',
                     'owner' => 'Darth Vader',
                     'type' => 'Victory Star Destroyer',
                  ]);
      $response->assertRedirect(route('admin.entries.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Entry',
                     'name' => 'Updated Entry',
                     'action' => 'updated',
                     'id' => $entry->entity_id,
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_entry_destroy()
   {
      $entry = $this->entries->random();
      $response = $this->delete(route('admin.entries.destroy', $entry));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_entry_destroy()
   {
      $entry = $this->entries->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.entries.destroy', $entry));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_entry_destroy()
   {
      $entry = $this->entries->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.entries.destroy', $entry));
      $response->assertRedirect(route('admin.entries.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Entry',
                     'name' => $entry->name,
                     'action' => 'deleted',
                     'id' => $entry->entity_id,
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_entry_search()
   {
      $response = $this->post(route('admin.entries.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_entry_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.entries.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_entry_search()
   {
      $entry = $this->entries->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.entries.search', [
                     'attribute' => 'name',
                     'value' => $entry->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($entry->id)
               ->assertSee($entry->name);
   }
}