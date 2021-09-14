<?php

namespace AndrykVP\Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\News\Models\Tag;
use App\Models\User;

class TagWebTest extends TestCase
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
   function guest_cannot_access_tag_index()
   {
      $response = $this->get(route('admin.tags.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_tag_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.tags.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_tag_index()
   {
      $tag = $this->tags->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.tags.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($tag->id)
               ->assertSee($tag->name);
   }

   /** @test */
   function guest_cannot_access_tag_show()
   {
      $tag = $this->tags->random();
      $response = $this->get(route('admin.tags.show', $tag));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_tag_show()
   {
      $tag = $this->tags->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.tags.show', $tag));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_tag_show()
   {
      $tag = $this->tags->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.tags.show', $tag));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.tag')
               ->assertSee($tag->id)
               ->assertSee($tag->name);
   }

   /** @test */
   function guest_cannot_access_tag_create()
   {
      $response = $this->get(route('admin.tags.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_tag_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.tags.create'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_tag_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.tags.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_tag_store()
   {
      $response = $this->post(route('admin.tags.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_tag_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.tags.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_tag_store()
   {
      $tag = Tag::factory()->make();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.tags.store'), $tag->toArray());
      $response->assertRedirect(route('admin.tags.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Tag',
                     'name' => $tag->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_tag_edit()
   {
      $tag = $this->tags->random();
      $response = $this->get(route('admin.tags.edit', $tag));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_tag_edit()
   {
      $tag = $this->tags->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.tags.edit', $tag));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_tag_edit()
   {
      $tag = $this->tags->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.tags.edit', $tag));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($tag->id)
               ->assertSee($tag->name);
   }

   /** @test */
   function guest_cannot_access_tag_update()
   {
      $tag = $this->tags->random();
      $response = $this->patch(route('admin.tags.update', $tag), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_tag_update()
   {
      $tag = $this->tags->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.tags.update', $tag), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_tag_update()
   {
      $tag = $this->tags->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.tags.update', $tag), [
                     'id' => $tag->id,
                     'name' => 'Updated Tag'
                  ]);
      $response->assertRedirect(route('admin.tags.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Tag',
                     'name' => 'Updated Tag',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_tag_destroy()
   {
      $tag = $this->tags->random();
      $response = $this->delete(route('admin.tags.destroy', $tag));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_tag_destroy()
   {
      $tag = $this->tags->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.tags.destroy', $tag));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_tag_destroy()
   {
      $tag = $this->tags->random();
      $response = $this->actingAs($this->admin)
      ->withoutExceptionHandling()
                  ->delete(route('admin.tags.destroy', $tag));
      $response->assertRedirect(route('admin.tags.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Tag',
                     'name' => $tag->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_tag_search()
   {
      $response = $this->post(route('admin.tags.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_tag_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.tags.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_tag_search()
   {
      $tag = $this->tags->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.tags.search', [
                     'attribute' => 'name',
                     'value' => $tag->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($tag->id)
               ->assertSee($tag->name);
   }
}