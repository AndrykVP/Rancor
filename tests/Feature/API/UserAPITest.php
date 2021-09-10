<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\DB\Seeders\RancorSeeder;
use App\Models\User;

class UserAPITest extends TestCase
{
   use RefreshDatabase;

   protected $users, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without users
      $this->assertDatabaseCount('users', 0);

      // Initialize Test DB
      $this->users = User::factory()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_user_api_index()
   {
      $response = $this->getJson(route('api.auth.users.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_user_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.auth.users.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_user_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.auth.users.index'));
      $response->assertSuccessful()->assertJsonCount(5, 'data');
   }

   /** @test */
   function guest_cannot_access_user_api_show()
   {
      $user = $this->users->random();
      $response = $this->getJson(route('api.auth.users.show', $user));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_user_api_show()
   {
      $user = $this->users->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.auth.users.show', $user));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_user_api_show()
   {
      $user = $this->users->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.auth.users.show', $user));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar,
            'signature' => $user->signature,
            'email' => $user->email,
            'nickname' => $user->nickname,
            'quote' => $user->quote,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_user_api_update()
   {
      $user = $this->users->random();
      $response = $this->patchJson(route('api.auth.users.update', $user), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_user_api_update()
   {
      $user = $this->users->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.auth.users.update', $user), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_user_api_update()
   {
      Storage::fake('public');

      $user = $this->users->random();
      $avatar = UploadedFile::fake()->image($user->id . '.png', 150, 150)->size(100);
      $signature = UploadedFile::fake()->image($user->id . '.png', 50, 50)->size(100);
      $response = $this->actingAs($this->admin, 'api')
                  ->withoutExceptionHandling()
                  ->patchJson(route('api.auth.users.update', $user), [
                     'name' => 'Updated User',
                     'email' => 'example@example.com',
                     'nickname' => 'Nick',
                     'quote' => 'Some random quote',
                     'avatar' => 'http://www.example.com/image.png',
                     'signature' => '<center><img>http://www.example.com/image.png</img></center',
                     'avatarFile' => $avatar,
                     'signatureFile' => $signature,
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'User "Updated User" has been updated'
      ]);

      Storage::disk('public')->assertExists('ids/avatars/' . $avatar->name);
      Storage::disk('public')->assertExists('ids/signatures/' . $signature->name);
   }

   /** @test */
   function guest_cannot_access_user_api_destroy()
   {
      $user = $this->users->random();
      $response = $this->deleteJson(route('api.auth.users.destroy', $user));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_user_api_destroy()
   {
      $user = $this->users->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.auth.users.destroy', $user));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_user_api_destroy()
   {
      $user = $this->users->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.auth.users.destroy', $user));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'User "'. $user->name .'" has been deleted'
      ]);
   }

   /** @test */
   function guest_cannot_access_user_api_search()
   {
      $response = $this->postJson(route('api.auth.users.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_user_api_search()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.auth.users.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_user_api_search()
   {
      $user = $this->users->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.auth.users.search', [
                     'attribute' => 'name',
                     'value' => $user->name,
                  ]));
      $response->assertSuccessful()->assertJsonFragment(['id' => $user->id]);
   }
}