<?php

namespace AndrykVP\Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Forums\Models\Category;
use App\Models\User;

class CategoryWebTest extends TestCase
{
   use RefreshDatabase;

   protected $categories, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Categories
      $this->assertDatabaseCount('forum_categories', 0);

      // Initialize Test DB
      $this->categories = Category::factory()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_category_index()
   {
      $response = $this->get(route('admin.categories.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_category_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.categories.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_category_index()
   {
      $category = $this->categories->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.categories.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($category->id)
               ->assertSee($category->name);
   }

   /** @test */
   function guest_cannot_access_category_show()
   {
      $category = $this->categories->random();
      $response = $this->get(route('admin.categories.show', $category));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_category_show()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.categories.show', $category));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_category_show()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.categories.show', $category));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.category')
               ->assertSee($category->id)
               ->assertSee($category->name)
               ->assertSee($category->slug)
               ->assertSee($category->description)
               ->assertSee($category->color);
   }

   /** @test */
   function guest_cannot_access_category_create()
   {
      $response = $this->get(route('admin.categories.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_category_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.categories.create'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_category_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.categories.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_category_store()
   {
      $response = $this->post(route('admin.categories.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_category_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.categories.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_category_store()
   {
      $category = Category::factory()->make();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.categories.store'), $category->toArray());
      $response->assertRedirect(route('admin.categories.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Category',
                     'name' => $category->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_category_edit()
   {
      $category = $this->categories->random();
      $response = $this->get(route('admin.categories.edit', $category));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_category_edit()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.categories.edit', $category));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_category_edit()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.categories.edit', $category));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($category->id)
               ->assertSee($category->name)
               ->assertSee($category->slug)
               ->assertSee($category->description)
               ->assertSee($category->color)
               ->assertSee($category->lineup);
   }

   /** @test */
   function guest_cannot_access_category_update()
   {
      $category = $this->categories->random();
      $response = $this->patch(route('admin.categories.update', $category), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_category_update()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.categories.update', $category), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_category_update()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.categories.update', $category), [
                     'id' => $category->id,
                     'name' => 'Updated Category',
                     'slug' => 'some-slug',
                     'description' => 'Updated Category Description',
                     'color' => '#123456',
                     'lineup' => 1
                  ]);
      $response->assertRedirect(route('admin.categories.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Category',
                     'name' => 'Updated Category',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_category_destroy()
   {
      $category = $this->categories->random();
      $response = $this->delete(route('admin.categories.destroy', $category));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_category_destroy()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.categories.destroy', $category));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_category_destroy()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.categories.destroy', $category));
      $response->assertRedirect(route('admin.categories.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Category',
                     'name' => $category->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_category_search()
   {
      $response = $this->post(route('admin.categories.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_category_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.categories.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_category_search()
   {
      $category = $this->categories->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.categories.search', [
                     'attribute' => 'name',
                     'value' => $category->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($category->id)
               ->assertSee($category->name);
   }
}