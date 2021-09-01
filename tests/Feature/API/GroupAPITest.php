<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Forums\Models\Group;
use App\Models\User;

class GroupAPITest extends TestCase
{
   use RefreshDatabase;

   protected $groups, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without groups
      $this->assertDatabaseCount('forum_groups', 0);

      // Initialize Test DB
      $this->groups = Group::factory()->count(3)->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_group_api_index()
   {
      $response = $this->getJson(route('api.forums.groups.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_group_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.forums.groups.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_group_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.forums.groups.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_group_api_show()
   {
      $group = $this->groups->random();
      $response = $this->getJson(route('api.forums.groups.show', $group));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_group_api_show()
   {
      $group = $this->groups->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.forums.groups.show', $group));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_group_api_show()
   {
      $group = $this->groups->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.forums.groups.show', $group));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $group->id,
            'name' => $group->name,
            'description' => $group->description,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_group_api_store()
   {
      $response = $this->postJson(route('api.forums.groups.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_group_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.forums.groups.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_group_api_store()
   {
      $group = Group::factory()->make();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.forums.groups.store'), $group->toArray());
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Group "'. $group->name .'" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_group_api_update()
   {
      $group = $this->groups->random();
      $response = $this->patchJson(route('api.forums.groups.update', $group), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_group_api_update()
   {
      $group = $this->groups->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.forums.groups.update', $group), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_group_api_update()
   {
      $group = $this->groups->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.forums.groups.update', $group), [
                     'id' => $group->id,
                     'name' => 'Updated Group',
                     'description' => 'Updated description',
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Group "Updated Group" has been updated'
      ]);
   }
   /** @test */
   function guest_cannot_access_group_api_destroy()
   {
      $group = $this->groups->random();
      $response = $this->deleteJson(route('api.forums.groups.destroy', $group));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_group_api_destroy()
   {
      $group = $this->groups->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.forums.groups.destroy', $group));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_group_api_destroy()
   {
      $group = $this->groups->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.forums.groups.destroy', $group));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Group "'. $group->name .'" has been deleted'
      ]);
   }
}