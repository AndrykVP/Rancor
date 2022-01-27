<?php

namespace AndrykVP\Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Auth\Models\Permission;
use App\Models\User;

class PermissionWebTest extends TestCase
{
   use RefreshDatabase;

   protected $permissions, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Permissions
      $this->assertDatabaseCount('rancor_permissions', 0);

      // Initialize Test DB
      $this->permissions = Permission::factory()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_permission_index()
   {
      $response = $this->get(route('admin.permissions.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_permission_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.permissions.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_permission_index()
   {
      $permission = $this->permissions->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.permissions.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($permission->id)
               ->assertSee($permission->name);
   }

   /** @test */
   function guest_cannot_access_permission_show()
   {
      $permission = $this->permissions->random();
      $response = $this->get(route('admin.permissions.show', $permission));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_permission_show()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.permissions.show', $permission));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_permission_show()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.permissions.show', $permission));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.permission')
               ->assertSee($permission->id)
               ->assertSee($permission->name)
               ->assertSee($permission->description);
   }

   /** @test */
   function guest_cannot_access_permission_create()
   {
      $response = $this->get(route('admin.permissions.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_permission_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.permissions.create'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_permission_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.permissions.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_permission_store()
   {
      $response = $this->post(route('admin.permissions.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_permission_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.permissions.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_permission_store()
   {
      $permission = Permission::factory()->make();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.permissions.store'), $permission->toArray());
      $response->assertRedirect(route('admin.permissions.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Permission',
                     'name' => $permission->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_permission_edit()
   {
      $permission = $this->permissions->random();
      $response = $this->get(route('admin.permissions.edit', $permission));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_permission_edit()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.permissions.edit', $permission));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_permission_edit()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.permissions.edit', $permission));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($permission->id)
               ->assertSee($permission->name)
               ->assertSee($permission->description);
   }

   /** @test */
   function guest_cannot_access_permission_update()
   {
      $permission = $this->permissions->random();
      $response = $this->patch(route('admin.permissions.update', $permission), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_permission_update()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.permissions.update', $permission), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_permission_update()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.permissions.update', $permission), [
                     'id' => $permission->id,
                     'name' => 'Updated Permission',
                     'description' => 'Lorem ipsum dolot',
                  ]);
      $response->assertRedirect(route('admin.permissions.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Permission',
                     'name' => 'updated-permission',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_permission_destroy()
   {
      $permission = $this->permissions->random();
      $response = $this->delete(route('admin.permissions.destroy', $permission));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_permission_destroy()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.permissions.destroy', $permission));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_permission_destroy()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.permissions.destroy', $permission));
      $response->assertRedirect(route('admin.permissions.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Permission',
                     'name' => $permission->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_permission_search()
   {
      $response = $this->post(route('admin.permissions.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_permission_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.permissions.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_permission_search()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.permissions.search', [
                     'attribute' => 'name',
                     'value' => Str::slug($permission->name),
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($permission->id)
               ->assertSee($permission->name);
   }
}