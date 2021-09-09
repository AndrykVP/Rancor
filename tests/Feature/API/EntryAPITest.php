<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Scanner\Models\Entry;
use App\Models\User;

class EntryAPITest extends TestCase
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
                     // ->forTerritory()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_entry_api_index()
   {
      $response = $this->getJson(route('api.scanner.entries.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_entry_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.scanner.entries.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_entry_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.scanner.entries.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_entry_api_show()
   {
      $entry = $this->entries->random();
      $response = $this->getJson(route('api.scanner.entries.show', $entry));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_entry_api_show()
   {
      $entry = $this->entries->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.scanner.entries.show', $entry));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_entry_api_show()
   {
      $entry = $this->entries->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.scanner.entries.show', $entry));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $entry->id,
            'entity_id' => $entry->entity_id,
            'type' => $entry->type,
            'name' => $entry->name,
            'owner' => $entry->owner,
            'position' => $entry->position,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_entry_api_store()
   {
      $response = $this->postJson(route('api.scanner.entries.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_entry_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.scanner.entries.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_entry_api_store()
   {
      $entry = Entry::factory()->make();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.scanner.entries.store'), $entry->toArray());
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Record for '.$entry->type.' "'.$entry->name.'" (#'.$entry->entity_id.') has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_entry_api_update()
   {
      $entry = $this->entries->random();
      $response = $this->patchJson(route('api.scanner.entries.update', $entry), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_entry_api_update()
   {
      $entry = $this->entries->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.scanner.entries.update', $entry), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_entry_api_update()
   {
      $entry = $this->entries->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.scanner.entries.update', $entry), [
                     'id' => $entry->id,
                     'entity_id' => 123456,
                     'type' => 'Some Type',
                     'name' => 'Updated Entry',
                     'owner' => 'Darth Vader',
                     'position' => [
                        'galaxy' => [
                           'x' => 1,
                           'y' => 1,
                        ],
                        'system' => [
                           'x' => 1,
                           'y' => 1,
                        ],
                     ],
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Record for Some Type "Updated Entry" (#123456) has been updated'
      ]);
   }

   /** @test */
   function guest_cannot_access_entry_api_destroy()
   {
      $entry = $this->entries->random();
      $response = $this->deleteJson(route('api.scanner.entries.destroy', $entry));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_entry_api_destroy()
   {
      $entry = $this->entries->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.scanner.entries.destroy', $entry));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_entry_api_destroy()
   {
      $entry = $this->entries->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.scanner.entries.destroy', $entry));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'All records of '.$entry->type.' "'.$entry->name.'" (#'.$entry->entity_id.') have been deleted'
      ]);
   }

   /** @test */
   function guest_cannot_access_entry_api_search()
   {
      $response = $this->postJson(route('api.scanner.entries.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_entry_api_search()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.scanner.entries.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_entry_api_search()
   {
      $entry = $this->entries->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.scanner.entries.search', [
                     'attribute' => 'name',
                     'value' => $entry->name,
                  ]));
      $response->assertSuccessful()->assertJsonFragment(['id' => $entry->id]);
   }
}