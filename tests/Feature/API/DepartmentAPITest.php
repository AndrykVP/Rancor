<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Structure\Models\Department;
use App\Models\User;

class DepartmentAPITest extends TestCase
{
   use RefreshDatabase;

   protected $departments, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Departments
      $this->assertDatabaseCount('structure_departments', 0);

      // Initialize Test DB
      $this->departments = Department::factory()
                     ->forFaction()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_department_api_index()
   {
      $response = $this->getJson(route('api.structure.departments.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_department_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.structure.departments.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_department_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.structure.departments.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_department_api_show()
   {
      $department = $this->departments->random();
      $response = $this->getJson(route('api.structure.departments.show', $department));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_department_api_show()
   {
      $department = $this->departments->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.structure.departments.show', $department));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_department_api_show()
   {
      $department = $this->departments->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.structure.departments.show', $department));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $department->id,
            'name' => $department->name,
            'description' => $department->description,
            'color' => $department->color,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_department_api_store()
   {
      $response = $this->postJson(route('api.structure.departments.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_department_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.structure.departments.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_department_api_store()
   {
      $department = Department::factory()->make(['faction_id' => 1]);
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.structure.departments.store'), $department->toArray());
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Department "'. $department->name .'" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_department_api_update()
   {
      $department = $this->departments->random();
      $response = $this->patchJson(route('api.structure.departments.update', $department), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_department_api_update()
   {
      $department = $this->departments->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.structure.departments.update', $department), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_department_api_update()
   {
      $department = $this->departments->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.structure.departments.update', $department), [
                     'id' => $department->id,
                     'name' => 'Updated Department',
                     'description' => 'Updated Department Description',
                     'color' => '#123456',
                     'faction_id' => $department->faction_id,
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Department "Updated Department" has been updated'
      ]);
   }

   /** @test */
   function guest_cannot_access_department_api_destroy()
   {
      $department = $this->departments->random();
      $response = $this->deleteJson(route('api.structure.departments.destroy', $department));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_department_api_destroy()
   {
      $department = $this->departments->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.structure.departments.destroy', $department));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_department_api_destroy()
   {
      $department = $this->departments->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.structure.departments.destroy', $department));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Department "'. $department->name .'" has been deleted'
      ]);
   }

   /** @test */
   function guest_cannot_access_department_api_search()
   {
      $response = $this->postJson(route('api.structure.departments.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_department_api_search()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.structure.departments.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_department_api_search()
   {
      $department = $this->departments->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.structure.departments.search', [
                     'attribute' => 'name',
                     'value' => $department->name,
                  ]));
      $response->assertSuccessful()->assertJsonFragment(['id' => $department->id]);
   }
}