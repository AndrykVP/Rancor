<?php

namespace Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Tests\TestCase;
use Rancor\Forums\Models\Group;
use App\Models\User;

class GroupWebTest extends TestCase
{
   use RefreshDatabase;

   protected $groups, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Groups
      $this->assertDatabaseCount('forum_groups', 0);

      // Initialize Test DB
      $this->groups = Group::factory()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_group_index()
   {
      $response = $this->get(route('admin.groups.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_group_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.groups.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_group_index()
   {
      $group = $this->groups->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.groups.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($group->id)
               ->assertSee($group->name);
   }

   /** @test */
   function guest_cannot_access_group_show()
   {
      $group = $this->groups->random();
      $response = $this->get(route('admin.groups.show', $group));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_group_show()
   {
      $group = $this->groups->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.groups.show', $group));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_group_show()
   {
      $group = $this->groups->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.groups.show', $group));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.group')
               ->assertSee($group->id)
               ->assertSee($group->name)
               ->assertSee($group->description);
   }

   /** @test */
   function guest_cannot_access_group_create()
   {
      $response = $this->get(route('admin.groups.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_group_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.groups.create'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_group_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.groups.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_group_store()
   {
      $response = $this->post(route('admin.groups.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_group_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.groups.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_group_store()
   {
      $group = Group::factory()->make(['type_id' => 1]);
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.groups.store'), $group->toArray());
      $response->assertRedirect(route('admin.groups.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Group',
                     'name' => $group->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_group_edit()
   {
      $group = $this->groups->random();
      $response = $this->get(route('admin.groups.edit', $group));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_group_edit()
   {
      $group = $this->groups->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.groups.edit', $group));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_group_edit()
   {
      $group = $this->groups->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.groups.edit', $group));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($group->id)
               ->assertSee($group->name)
               ->assertSee($group->description);
   }

   /** @test */
   function guest_cannot_access_group_update()
   {
      $group = $this->groups->random();
      $response = $this->patch(route('admin.groups.update', $group), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_group_update()
   {
      $group = $this->groups->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.groups.update', $group), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_group_update()
   {
      $group = $this->groups->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.groups.update', $group), [
                     'id' => $group->id,
                     'name' => 'Updated Group',
                     'description' => 'Updated Group Description',
                  ]);
      $response->assertRedirect(route('admin.groups.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Group',
                     'name' => 'Updated Group',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_group_destroy()
   {
      $group = $this->groups->random();
      $response = $this->delete(route('admin.groups.destroy', $group));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_group_destroy()
   {
      $group = $this->groups->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.groups.destroy', $group));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_group_destroy()
   {
      $group = $this->groups->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.groups.destroy', $group));
      $response->assertRedirect(route('admin.groups.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Group',
                     'name' => $group->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_group_search()
   {
      $response = $this->post(route('admin.groups.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_group_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.groups.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_group_search()
   {
      $group = $this->groups->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.groups.search', [
                     'attribute' => 'name',
                     'value' => $group->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($group->id)
               ->assertSee($group->name);
   }
}