<?php

namespace AndrykVP\Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Scanner\Models\TerritoryType;
use App\Models\User;

class TerritoryTypeWebTest extends TestCase
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
   function guest_cannot_access_territory_type_index()
   {
      $response = $this->get(route('admin.territorytypes.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_territory_type_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.territorytypes.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_territory_type_index()
   {
      $territorytype = $this->territorytypes->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.territorytypes.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($territorytype->id)
               ->assertSee($territorytype->name);
   }

   /** @test */
   function guest_cannot_access_territory_type_show()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->get(route('admin.territorytypes.show', $territorytype));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_territory_type_show()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.territorytypes.show', $territorytype));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_territory_type_show()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.territorytypes.show', $territorytype));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.territorytypes')
               ->assertSee($territorytype->id)
               ->assertSee($territorytype->name)
               ->assertSee($territorytype->image);
   }

   /** @test */
   function guest_cannot_access_territory_type_create()
   {
      $response = $this->get(route('admin.territorytypes.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_territory_type_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.territorytypes.create'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_territory_type_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.territorytypes.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_territory_type_store()
   {
      $response = $this->post(route('admin.territorytypes.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_territory_type_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.territorytypes.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_territory_type_store()
   {
      $territorytype = TerritoryType::factory()->make(['type_id' => 1]);
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.territorytypes.store'), $territorytype->toArray());
      $response->assertRedirect(route('admin.territorytypes.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Territory Type',
                     'name' => $territorytype->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_territory_type_edit()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->get(route('admin.territorytypes.edit', $territorytype));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_territory_type_edit()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.territorytypes.edit', $territorytype));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_territory_type_edit()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.territorytypes.edit', $territorytype));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($territorytype->id)
               ->assertSee($territorytype->name)
               ->assertSee($territorytype->image);
   }

   /** @test */
   function guest_cannot_access_territory_type_update()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->patch(route('admin.territorytypes.update', $territorytype), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_territory_type_update()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.territorytypes.update', $territorytype), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_territory_type_update()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.territorytypes.update', $territorytype), [
                     'id' => $territorytype->id,
                     'name' => 'Updated TerritoryType',
                     'image' => 'http://www.example.com/image.png',
                  ]);
      $response->assertRedirect(route('admin.territorytypes.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Territory Type',
                     'name' => 'Updated TerritoryType',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_territory_type_destroy()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->delete(route('admin.territorytypes.destroy', $territorytype));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_territory_type_destroy()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.territorytypes.destroy', $territorytype));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_territory_type_destroy()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.territorytypes.destroy', $territorytype));
      $response->assertRedirect(route('admin.territorytypes.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Territory Type',
                     'name' => $territorytype->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_territory_type_search()
   {
      $response = $this->post(route('admin.territorytypes.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_territory_type_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.territorytypes.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_territory_type_search()
   {
      $territorytype = $this->territorytypes->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.territorytypes.search', [
                     'attribute' => 'name',
                     'value' => $territorytype->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($territorytype->id)
               ->assertSee($territorytype->name);
   }
}