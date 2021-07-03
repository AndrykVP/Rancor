<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\News\Models\Tag;
use AndrykVP\Rancor\News\Models\Article;
use AndrykVP\Rancor\Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_tag()
    {
        $tag = Tag::factory()
        ->has(Article::factory()->forAuthor()->count(10))
        ->create([
            'name' => 'Fake Title'
        ]);
        $this->assertNotNull($tag);
        return $tag->load('articles');
    }

    /** 
     * @test
     * @depends make_tag
     */
    function tag_has_name($tag)
    {
        $this->assertEquals('Fake Title', $tag->name);
    }

    /**
     * @test
     * @depends make_tag
     */
    function tag_has_articles($tag)
    {
        $this->assertCount(10, $tag->articles);
    }
}