<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Auth\Models\Role;
use AndrykVP\Rancor\DB\Seeders\RancorSeeder;
use App\Models\User;

class RoleAPITest extends TestCase
{
   use RefreshDatabase;

   protected $roles, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start with Roles
      $this->seed(RancorSeeder::class);
      $this->assertDatabaseCount('rancor_roles', 9);

      // Initialize Test DB
      $this->roles = Role::all();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_role_api_index()
   {
      $response = $this->getJson(route('api.auth.roles.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_role_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.auth.roles.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_role_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.auth.roles.index'));
      $response->assertSuccessful()->assertJsonCount(9, 'data');
   }

   /** @test */
   function guest_cannot_access_role_api_show()
   {
      $role = $this->roles->random();
      $response = $this->getJson(route('api.auth.roles.show', $role));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_role_api_show()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.auth.roles.show', $role));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_role_api_show()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.auth.roles.show', $role));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $role->id,
            'name' => $role->name,
            'description' => $role->description,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_role_api_store()
   {
      $role = $this->roles->random();
      $response = $this->postJson(route('api.auth.roles.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_role_api_store()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.auth.roles.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_role_api_store()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.auth.roles.store'), [
                     'name' => 'Example Role',
                     'description' => 'Example description',
                     'permissions' => [1,2,3]
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Role "Example Role" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_role_api_update()
   {
      $role = $this->roles->random();
      $response = $this->patchJson(route('api.auth.roles.update', $role), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_role_api_update()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.auth.roles.update', $role), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_role_api_update()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.auth.roles.update', $role), [
                     'name' => 'Updated Role',
                     'description' => 'Updated description',
                     'permissions' => [1,2,3]
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Role "Updated Role" has been updated'
      ]);
   }

   /** @test */
   function guest_cannot_access_role_api_destroy()
   {
      $role = $this->roles->random();
      $response = $this->deleteJson(route('api.auth.roles.destroy', $role));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_role_api_destroy()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.auth.roles.destroy', $role));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_role_api_destroy()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.auth.roles.destroy', $role));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Role "'. $role->name .'" has been deleted'
      ]);
   }

   /** @test */
   function guest_cannot_access_role_api_search()
   {
      $response = $this->postJson(route('api.auth.roles.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_role_api_search()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.auth.roles.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_role_api_search()
   {
      $role = $this->roles->random();
      $response = $this->actingAs($this->admin, 'api')

      ->withoutExceptionHandling()
                  ->postJson(route('api.auth.roles.search', [
                     'attribute' => 'name',
                     'value' => $role->name,
                  ]));
      $response->assertSuccessful()->assertJsonFragment(['id' => $role->id]);
   }
}