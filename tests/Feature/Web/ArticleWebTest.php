<?php

namespace Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Tests\TestCase;
use Rancor\News\Models\Article;
use App\Models\User;

class ArticleWebTest extends TestCase
{
   use RefreshDatabase;

   protected $articles, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Articles
      $this->assertDatabaseCount('news_articles', 0);

      // Initialize Test DB
      $this->articles = Article::factory()
                     ->hasTags(2)
                     ->forAuthor()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_article_index()
   {
      $response = $this->get(route('admin.articles.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_article_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.articles.index'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_article_index()
   {
      $article = $this->articles->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.articles.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($article->id)
               ->assertSee($article->name);
   }

   /** @test */
   function guest_cannot_access_article_show()
   {
      $article = $this->articles->random();
      $response = $this->get(route('admin.articles.show', $article));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_article_show()
   {
      $article = $this->articles->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.articles.show', $article));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_article_show()
   {
      $article = $this->articles->random()->load('author');
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.articles.show', $article));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.article')
               ->assertSee($article->id)
               ->assertSee($article->name)
               ->assertSee($article->author->name);
   }

   /** @test */
   function guest_cannot_access_article_create()
   {
      $response = $this->get(route('admin.articles.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_article_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.articles.create'));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_article_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.articles.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_article_store()
   {
      $response = $this->post(route('admin.articles.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_article_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.articles.store'), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_article_store()
   {
      $article = Article::factory()->make();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.articles.store'), $article->toArray());
      $response->assertRedirect(route('admin.articles.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Article',
                     'name' => $article->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_article_edit()
   {
      $article = $this->articles->random();
      $response = $this->get(route('admin.articles.edit', $article));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_article_edit()
   {
      $article = $this->articles->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.articles.edit', $article));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_article_edit()
   {
      $article = $this->articles->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.articles.edit', $article));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($article->id)
               ->assertSee($article->name)
               ->assertSee($article->body)
               ->assertSee($article->description);
   }

   /** @test */
   function guest_cannot_access_article_update()
   {
      $article = $this->articles->random();
      $response = $this->patch(route('admin.articles.update', $article), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_article_update()
   {
      $article = $this->articles->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.articles.update', $article), []);
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_article_update()
   {
      $article = $this->articles->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.articles.update', $article), [
                     'id' => $article->id,
                     'name' => 'Updated Article',
                     'body' => 'Updated Article Body',
                     'description' => 'Updated Article Description',
                     'is_published' => true
                  ]);
      $response->assertRedirect(route('admin.articles.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Article',
                     'name' => 'Updated Article',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_article_destroy()
   {
      $article = $this->articles->random();
      $response = $this->delete(route('admin.articles.destroy', $article));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_article_destroy()
   {
      $article = $this->articles->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.articles.destroy', $article));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_article_destroy()
   {
      $article = $this->articles->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.articles.destroy', $article));
      $response->assertRedirect(route('admin.articles.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Article',
                     'name' => $article->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_article_search()
   {
      $response = $this->post(route('admin.articles.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_article_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.articles.search', []));
      $response->assertStatus(403);
   }

   /** @test */
   function admin_can_access_article_search()
   {
      $article = $this->articles->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.articles.search', [
                     'attribute' => 'name',
                     'value' => $article->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($article->id)
               ->assertSee($article->name);
   }
}