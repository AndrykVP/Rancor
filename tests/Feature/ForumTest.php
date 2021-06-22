<?php

namespace AndrykVP\Rancor\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use JohnDoe\BlogPackage\Models\Post;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Auth\Models\User;

class ForumTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
   function admin_users_can_create_a_board()
   {
       // To make sure we don't start with a Post
       $this->assertCount(0, Post::all());

       $author = User::factory()->create();

       $response = $this->actingAs($author)->post(route('posts.store'), [
           'title' => 'My first fake title',
           'body'  => 'My first fake body',
       ]);

       $this->assertCount(1, Post::all());

       tap(Post::first(), function ($post) use ($response, $author) {
           $this->assertEquals('My first fake title', $post->title);
           $this->assertEquals('My first fake body', $post->body);
           $this->assertTrue($post->author->is($author));
           $response->assertRedirect(route('posts.show', $post));
       });
   }
}