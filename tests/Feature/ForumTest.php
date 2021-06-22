<?php

namespace AndrykVP\Rancor\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Forums\Models\Category;
use App\Models\User;

class ForumTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
   function users_can_access_forum_index()
    {
        // To make sure we don't start with a Post
        $this->assertCount(0, Category::all());
        $user = User::factory()->create();
        
        $this->withoutExceptionHandling();
        $response = $this->actingAs($user)->get(route('forums.index'));
        $response->dumpHeaders();
        $response->assertSuccessful();
        

      //   $author = User::factory()->create();

      //   $response = $this->actingAs($author)->post(route('posts.store'), [
      //       'title' => 'My first fake title',
      //       'body'  => 'My first fake body',
      //   ]);

      //   $this->assertCount(1, Post::all());

      //   tap(Post::first(), function ($post) use ($response, $author) {
      //       $this->assertEquals('My first fake title', $post->sentence(5));
      //       $this->assertEquals('My first fake body', $post->body);
      //       $this->assertTrue($post->author->is($author));
      //       $response->assertRedirect(route('posts.show', $post));
      //   });
    }
}