<?php

namespace Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Rancor\Tests\TestCase;
use Rancor\Structure\Models\Department;
use Rancor\Structure\Models\Rank;
use App\Models\User;

class UserWebTest extends TestCase
{
   use RefreshDatabase;

   protected $users, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Users
      $this->assertDatabaseCount('users', 0);

      // Initialize Test DB
      $this->users = User::factory()
                     ->for(Rank::factory()->for(Department::factory()->forFaction()))
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_user_index()
   {
      $response = $this->get(route('admin.users.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_user_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.users.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_user_index()
   {
      $user = $this->users->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.users.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($user->id)
               ->assertSee($user->name);
   }

   /** @test */
   function guest_cannot_access_user_show()
   {
      $user = $this->users->random();
      $response = $this->get(route('admin.users.show', $user));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_user_show()
   {
      $user = $this->users->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.users.show', $user));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_user_show()
   {
      $user = $this->users->random()->load('rank.department.faction');
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.users.show', $user));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.user')
               ->assertSee($user->id)
               ->assertSee($user->name)
               ->assertSee($user->email)
               ->assertSee($user->rank->department->faction->name)
               ->assertSee($user->rank->department->name)
               ->assertSee($user->rank->name);
   }

   /** @test */
   function guest_cannot_access_user_edit()
   {
      $user = $this->users->random();
      $response = $this->get(route('admin.users.edit', $user));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_user_edit()
   {
      $user = $this->users->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.users.edit', $user));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_user_edit()
   {
      $user = $this->users->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.users.edit', $user));
      $response->assertSuccessful()
               ->assertViewIs('rancor::users.edit')
               ->assertSee($user->id)
               ->assertSee($user->first_name)
               ->assertSee($user->last_name)
               ->assertSee($user->email)
               ->assertSee($user->nickname)
               ->assertSee($user->quote)
               ->assertSee($user->avatar)
               ->assertSee($user->signature);
   }

   /** @test */
   function guest_cannot_access_user_update()
   {
      $user = $this->users->random();
      $response = $this->patch(route('admin.users.update', $user), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_user_update()
   {
      $user = $this->users->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.users.update', $user), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_user_update()
   {
      Storage::fake('idgen');

      $user = $this->users->random();
      $avatar = UploadedFile::fake()->image($user->id . '.png', 150, 150)->size(100);
      $signature = UploadedFile::fake()->image($user->id . '.png', 50, 50)->size(100);
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.users.update', $user), [
                     'id' => $user->id,
                     'first_name' => 'Updated',
                     'last_name' => 'User',
                     'email' => 'example@example.com',
                     'nickname' => 'UwU',
                     'quote' => 'Lorem ipsum dolot',
                     'avatar' => 'http://www.example.com/image.png',
                     'signature' => '<center><img src="http://www.example.com/image.png" /></center>',
                     'avatarFile' => $avatar,
                     'signatureFile' => $signature,
                  ]);
      $response->assertRedirect(route('admin.users.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'User',
                     'name' => 'Updated User',
                     'action' => 'updated',
                  ]
               ]);
      
      Storage::disk('idgen')->assertExists('images/avatars/' . $avatar->name);
      Storage::disk('idgen')->assertExists('images/signatures/' . $signature->name);
   }
   
   /** @test */
   function guest_cannot_access_user_destroy()
   {
      $user = $this->users->random();
      $response = $this->delete(route('admin.users.destroy', $user));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_user_destroy()
   {
      $user = $this->users->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.users.destroy', $user));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_user_destroy()
   {
      $user = $this->users->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.users.destroy', $user));
      $response->assertRedirect(route('admin.users.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'User',
                     'name' => $user->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_user_search()
   {
      $response = $this->post(route('admin.users.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_user_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.users.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_user_search()
   {
      $user = $this->users->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.users.search', [
                     'attribute' => 'first_name',
                     'value' => $user->first_name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($user->id)
               ->assertSee($user->name);
   }

   /** @test */
   function guest_cannot_ban_users()
   {
      $user = $this->users->random();
      $response = $this->patch(route('admin.users.ban', $user));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_ban_users()
   {
      $user = $this->users->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.users.ban', $user));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_ban_users()
   {
      $user = $this->users->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.users.ban', $user), [
                     'status' => 1,
                     'reason' => 'Some reason',
                  ]);
      $response->assertRedirect(route('admin.users.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'User',
                     'name' => $user->name,
                     'action' => 'banned',
                  ]
               ]);
   }
}