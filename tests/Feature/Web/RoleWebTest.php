<?php

namespace Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Tests\TestCase;
use Rancor\Auth\Models\Role;
use App\Models\User;

class RoleWebTest extends TestCase
{
   use RefreshDatabase;

   protected $roles, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Roles
      $this->assertDatabaseCount('rancor_roles', 0);

      // Initialize Test DB
      $this->roles = Role::factory()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_role_index()
   {
      $response = $this->get(route('admin.roles.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_role_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.roles.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_role_index()
   {
      $role = $this->roles->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.roles.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($role->id)
               ->assertSee($role->name);
   }

   /** @test */
   function guest_cannot_access_role_show()
   {
      $role = $this->roles->random();
      $response = $this->get(route('admin.roles.show', $role));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_role_show()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.roles.show', $role));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_role_show()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.roles.show', $role));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.role')
               ->assertSee($role->id)
               ->assertSee($role->name)
               ->assertSee($role->description);
   }

   /** @test */
   function guest_cannot_access_role_create()
   {
      $response = $this->get(route('admin.roles.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_role_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.roles.create'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_role_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.roles.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_role_store()
   {
      $response = $this->post(route('admin.roles.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_role_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.roles.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_role_store()
   {
      $role = Role::factory()->make(['permissions' => [1, 2, 3]]);
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.roles.store'), $role->toArray());
      $response->assertRedirect(route('admin.roles.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Role',
                     'name' => $role->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_role_edit()
   {
      $role = $this->roles->random();
      $response = $this->get(route('admin.roles.edit', $role));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_role_edit()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.roles.edit', $role));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_role_edit()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.roles.edit', $role));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($role->id)
               ->assertSee($role->name)
               ->assertSee($role->description);
   }

   /** @test */
   function guest_cannot_access_role_update()
   {
      $role = $this->roles->random();
      $response = $this->patch(route('admin.roles.update', $role), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_role_update()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.roles.update', $role), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_role_update()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.roles.update', $role), [
                     'id' => $role->id,
                     'name' => 'Updated Role',
                     'description' => 'Lorem ipsum dolot',
                     'permissions' => [1, 2, 3],
                  ]);
      $response->assertRedirect(route('admin.roles.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Role',
                     'name' => 'Updated Role',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_role_destroy()
   {
      $role = $this->roles->random();
      $response = $this->delete(route('admin.roles.destroy', $role));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_role_destroy()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.roles.destroy', $role));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_role_destroy()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.roles.destroy', $role));
      $response->assertRedirect(route('admin.roles.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Role',
                     'name' => $role->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_role_search()
   {
      $response = $this->post(route('admin.roles.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_role_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.roles.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_role_search()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.roles.search', [
                     'attribute' => 'name',
                     'value' => $role->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($role->id)
               ->assertSee($role->name);
   }
}