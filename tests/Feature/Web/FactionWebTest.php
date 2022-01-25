<?php

namespace AndrykVP\Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Structure\Models\Faction;
use App\Models\User;

class FactionWebTest extends TestCase
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
   function guest_cannot_access_faction_index()
   {
      $response = $this->get(route('admin.factions.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_faction_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.factions.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_faction_index()
   {
      $faction = $this->factions->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.factions.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($faction->id)
               ->assertSee($faction->name);
   }

   /** @test */
   function guest_cannot_access_faction_show()
   {
      $faction = $this->factions->random();
      $response = $this->get(route('admin.factions.show', $faction));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_faction_show()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.factions.show', $faction));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_faction_show()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.factions.show', $faction));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.faction')
               ->assertSee($faction->id)
               ->assertSee($faction->name)
               ->assertSee($faction->initials)
               ->assertSee($faction->description);
   }

   /** @test */
   function guest_cannot_access_faction_create()
   {
      $response = $this->get(route('admin.factions.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_faction_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.factions.create'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_faction_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.factions.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_faction_store()
   {
      $response = $this->post(route('admin.factions.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_faction_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.factions.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_faction_store()
   {
      $faction = Faction::factory()->make();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.factions.store'), $faction->toArray());
      $response->assertRedirect(route('admin.factions.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Faction',
                     'name' => $faction->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_faction_edit()
   {
      $faction = $this->factions->random();
      $response = $this->get(route('admin.factions.edit', $faction));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_faction_edit()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.factions.edit', $faction));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_faction_edit()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.factions.edit', $faction));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($faction->id)
               ->assertSee($faction->name)
               ->assertSee($faction->initials)
               ->assertSee($faction->description);
   }

   /** @test */
   function guest_cannot_access_faction_update()
   {
      $faction = $this->factions->random();
      $response = $this->patch(route('admin.factions.update', $faction), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_faction_update()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.factions.update', $faction), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_faction_update()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.factions.update', $faction), [
                     'id' => $faction->id,
                     'name' => 'Updated Faction',
                     'initials' => 'ABC',
                     'description' => 'Updated Faction Description',
                  ]);
      $response->assertRedirect(route('admin.factions.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Faction',
                     'name' => 'Updated Faction',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_faction_destroy()
   {
      $faction = $this->factions->random();
      $response = $this->delete(route('admin.factions.destroy', $faction));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_faction_destroy()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.factions.destroy', $faction));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_faction_destroy()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.factions.destroy', $faction));
      $response->assertRedirect(route('admin.factions.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Faction',
                     'name' => $faction->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_faction_search()
   {
      $response = $this->post(route('admin.factions.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_faction_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.factions.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_faction_search()
   {
      $faction = $this->factions->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.factions.search', [
                     'attribute' => 'name',
                     'value' => $faction->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($faction->id)
               ->assertSee($faction->name);
   }
}