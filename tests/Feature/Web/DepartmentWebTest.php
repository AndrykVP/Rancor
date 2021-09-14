<?php

namespace AndrykVP\Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Structure\Models\Department;
use App\Models\User;

class DepartmentWebTest extends TestCase
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
   function guest_cannot_access_department_index()
   {
      $response = $this->get(route('admin.departments.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_department_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.departments.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_department_index()
   {
      $department = $this->departments->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.departments.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($department->id)
               ->assertSee($department->name);
   }

   /** @test */
   function guest_cannot_access_department_show()
   {
      $department = $this->departments->random();
      $response = $this->get(route('admin.departments.show', $department));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_department_show()
   {
      $department = $this->departments->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.departments.show', $department));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_department_show()
   {
      $department = $this->departments->random()->load('faction');
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.departments.show', $department));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.department')
               ->assertSee($department->id)
               ->assertSee($department->name)
               ->assertSee($department->description)
               ->assertSee($department->color)
               ->assertSee($department->faction->name);
   }

   /** @test */
   function guest_cannot_access_department_create()
   {
      $response = $this->get(route('admin.departments.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_department_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.departments.create'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_department_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.departments.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_department_store()
   {
      $response = $this->post(route('admin.departments.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_department_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.departments.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_department_store()
   {
      $department = Department::factory()->make(['faction_id' => 1]);
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.departments.store'), $department->toArray());
      $response->assertRedirect(route('admin.departments.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Department',
                     'name' => $department->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_department_edit()
   {
      $department = $this->departments->random();
      $response = $this->get(route('admin.departments.edit', $department));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_department_edit()
   {
      $department = $this->departments->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.departments.edit', $department));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_department_edit()
   {
      $department = $this->departments->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.departments.edit', $department));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($department->id)
               ->assertSee($department->name)
               ->assertSee($department->description)
               ->assertSee($department->color);
   }

   /** @test */
   function guest_cannot_access_department_update()
   {
      $department = $this->departments->random();
      $response = $this->patch(route('admin.departments.update', $department), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_department_update()
   {
      $department = $this->departments->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.departments.update', $department), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_department_update()
   {
      $department = $this->departments->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.departments.update', $department), [
                     'id' => $department->id,
                     'name' => 'Updated Department',
                     'description' => 'Updated Department Description',
                     'color' => '#123456',
                     'faction_id' => 1,
                  ]);
      $response->assertRedirect(route('admin.departments.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Department',
                     'name' => 'Updated Department',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_department_destroy()
   {
      $department = $this->departments->random();
      $response = $this->delete(route('admin.departments.destroy', $department));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_department_destroy()
   {
      $department = $this->departments->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.departments.destroy', $department));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_department_destroy()
   {
      $department = $this->departments->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.departments.destroy', $department));
      $response->assertRedirect(route('admin.departments.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Department',
                     'name' => $department->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_department_search()
   {
      $response = $this->post(route('admin.departments.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_department_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.departments.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_department_search()
   {
      $department = $this->departments->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.departments.search', [
                     'attribute' => 'name',
                     'value' => $department->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($department->id)
               ->assertSee($department->name);
   }
}