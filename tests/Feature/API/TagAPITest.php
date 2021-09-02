<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\News\Models\Tag;
use App\Models\User;

class TagAPITest extends TestCase
{
   use RefreshDatabase;

   protected $tags, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Tags
      $this->assertDatabaseCount('news_tags', 0);

      // Initialize Test DB
      $this->tags = Tag::factory()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_tag_api_index()
   {
      $response = $this->getJson(route('api.news.tags.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_tag_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.news.tags.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_tag_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.news.tags.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_tag_api_show()
   {
      $tag = $this->tags->random();
      $response = $this->getJson(route('api.news.tags.show', $tag));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_tag_api_show()
   {
      $tag = $this->tags->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.news.tags.show', $tag));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_tag_api_show()
   {
      $tag = $this->tags->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.news.tags.show', $tag));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $tag->id,
            'name' => $tag->name,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_tag_api_store()
   {
      $response = $this->postJson(route('api.news.tags.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_tag_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.news.tags.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_tag_api_store()
   {
      $tag = Tag::factory()->make();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.news.tags.store'), $tag->toArray());
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Tag "'. $tag->name .'" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_tag_api_update()
   {
      $tag = $this->tags->random();
      $response = $this->patchJson(route('api.news.tags.update', $tag), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_tag_api_update()
   {
      $tag = $this->tags->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.news.tags.update', $tag), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_tag_api_update()
   {
      $tag = $this->tags->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.news.tags.update', $tag), [
                     'id' => $tag->id,
                     'name' => 'Updated Tag',
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Tag "Updated Tag" has been updated'
      ]);
   }
   /** @test */
   function guest_cannot_access_tag_api_destroy()
   {
      $tag = $this->tags->random();
      $response = $this->deleteJson(route('api.news.tags.destroy', $tag));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_tag_api_destroy()
   {
      $tag = $this->tags->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.news.tags.destroy', $tag));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_tag_api_destroy()
   {
      $tag = $this->tags->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.news.tags.destroy', $tag));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Tag "'. $tag->name .'" has been deleted'
      ]);
   }
}