<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Auth\Models\Permission;
use AndrykVP\Rancor\DB\Seeders\RancorSeeder;
use App\Models\User;

class PermissionAPITest extends TestCase
{
   use RefreshDatabase;

   protected $permissions, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start with Permissions
      $this->seed(RancorSeeder::class);
      $this->assertDatabaseCount('rancor_permissions', 85);

      // Initialize Test DB
      $this->permissions = Permission::all();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_permission_api_index()
   {
      $response = $this->getJson(route('api.auth.permissions.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_permission_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.auth.permissions.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_permission_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.auth.permissions.index'));
      $response->assertSuccessful()->assertJsonCount(10, 'data');
   }

   /** @test */
   function guest_cannot_access_permission_api_show()
   {
      $permission = $this->permissions->random();
      $response = $this->getJson(route('api.auth.permissions.show', $permission));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_permission_api_show()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.auth.permissions.show', $permission));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_permission_api_show()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.auth.permissions.show', $permission));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $permission->id,
            'name' => $permission->name,
            'description' => $permission->description,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_permission_api_store()
   {
      $permission = $this->permissions->random();
      $response = $this->postJson(route('api.auth.permissions.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_permission_api_store()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.auth.permissions.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_permission_api_store()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.auth.permissions.store'), [
                     'name' => 'Example Permission',
                     'description' => 'Example description'
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Permission "example-permission" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_permission_api_update()
   {
      $permission = $this->permissions->random();
      $response = $this->patchJson(route('api.auth.permissions.update', $permission), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_permission_api_update()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.auth.permissions.update', $permission), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_permission_api_update()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.auth.permissions.update', $permission), [
                     'id' => $permission->id,
                     'name' => 'Updated Permission',
                     'description' => 'Updated description'
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Permission "updated-permission" has been updated'
      ]);
   }

   /** @test */
   function guest_cannot_access_permission_api_destroy()
   {
      $permission = $this->permissions->random();
      $response = $this->deleteJson(route('api.auth.permissions.destroy', $permission));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_permission_api_destroy()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.auth.permissions.destroy', $permission));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_permission_api_destroy()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.auth.permissions.destroy', $permission));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Permission "'. $permission->name .'" has been deleted'
      ]);
   }

   /** @test */
   function guest_cannot_access_permission_api_search()
   {
      $response = $this->postJson(route('api.auth.permissions.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_permission_api_search()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.auth.permissions.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_permission_api_search()
   {
      $permission = $this->permissions->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.auth.permissions.search', [
                     'attribute' => 'name',
                     'value' => $permission->name,
                  ]));
      $response->assertSuccessful()->assertJsonFragment(['id' => $permission->id]);
   }
}