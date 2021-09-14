<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Forums\Models\Category;
use App\Models\User;

class CategoryAPITest extends TestCase
{
   use RefreshDatabase;

   protected $categories, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without categories
      $this->assertDatabaseCount('forum_categories', 0);

      // Initialize Test DB
      $this->categories = Category::factory()->count(3)->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_category_api_index()
   {
      $response = $this->getJson(route('api.forums.categories.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_category_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.forums.categories.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_category_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.forums.categories.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_category_api_show()
   {
      $category = $this->categories->random();
      $response = $this->getJson(route('api.forums.categories.show', $category));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_category_api_show()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.forums.categories.show', $category));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_category_api_show()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.forums.categories.show', $category));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description,
            'color' => $category->color,
            'slug' => $category->slug,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_category_api_store()
   {
      $response = $this->postJson(route('api.forums.categories.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_category_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.forums.categories.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_category_api_store()
   {
      $category = Category::factory()->make();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.forums.categories.store'), $category->toArray());
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Category "'. $category->name .'" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_category_api_update()
   {
      $category = $this->categories->random();
      $response = $this->patchJson(route('api.forums.categories.update', $category), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_category_api_update()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.forums.categories.update', $category), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_category_api_update()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.forums.categories.update', $category), [
                     'id' => $category->id,
                     'name' => 'Updated Category',
                     'description' => 'Updated description',
                     'color' => '#123456',
                     'slug' => 'updated-category',
                     'lineup' => 1,
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Category "Updated Category" has been updated'
      ]);
   }

   /** @test */
   function guest_cannot_access_category_api_destroy()
   {
      $category = $this->categories->random();
      $response = $this->deleteJson(route('api.forums.categories.destroy', $category));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_category_api_destroy()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.forums.categories.destroy', $category));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_category_api_destroy()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.forums.categories.destroy', $category));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Category "'. $category->name .'" has been deleted'
      ]);
   }

   /** @test */
   function guest_cannot_access_category_api_search()
   {
      $response = $this->postJson(route('api.forums.categories.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_category_api_search()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.forums.categories.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_category_api_search()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.forums.categories.search', [
                     'attribute' => 'name',
                     'value' => $category->name,
                  ]));
      $response->assertSuccessful()->assertJsonFragment(['id' => $category->id]);
   }
}