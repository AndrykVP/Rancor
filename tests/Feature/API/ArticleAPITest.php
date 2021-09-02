<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\News\Models\Article;
use App\Models\User;

class ArticleAPITest extends TestCase
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
   function guest_cannot_access_article_api_index()
   {
      $response = $this->getJson(route('api.news.articles.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_article_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.news.articles.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_article_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.news.articles.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_article_api_show()
   {
      $article = $this->articles->random();
      $response = $this->getJson(route('api.news.articles.show', $article));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_article_api_show()
   {
      $article = $this->articles->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.news.articles.show', $article));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_article_api_show()
   {
      $article = $this->articles->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.news.articles.show', $article));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $article->id,
            'name' => $article->name,
            'body' => clean($article->body),
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_article_api_store()
   {
      $response = $this->postJson(route('api.news.articles.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_article_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.news.articles.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_article_api_store()
   {
      $article = Article::factory()->make();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.news.articles.store'), $article->toArray());
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Article "'. $article->name .'" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_article_api_update()
   {
      $article = $this->articles->random();
      $response = $this->patchJson(route('api.news.articles.update', $article), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_article_api_update()
   {
      $article = $this->articles->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.news.articles.update', $article), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_article_api_update()
   {
      $article = $this->articles->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.news.articles.update', $article), [
                     'id' => $article->id,
                     'name' => 'Updated Article',
                     'body' => 'Updated Article Body',
                     'description' => 'Updated Article Description',
                     'is_published' => true
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Article "Updated Article" has been updated'
      ]);
   }
   /** @test */
   function guest_cannot_access_article_api_destroy()
   {
      $article = $this->articles->random();
      $response = $this->deleteJson(route('api.news.articles.destroy', $article));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_article_api_destroy()
   {
      $article = $this->articles->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.news.articles.destroy', $article));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_article_api_destroy()
   {
      $article = $this->articles->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.news.articles.destroy', $article));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Article "'. $article->name .'" has been deleted'
      ]);
   }
}