<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\News\Models\Article;
use AndrykVP\Rancor\News\Models\Tag;
use AndrykVP\Rancor\Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_article()
    {
        $article = Article::factory()
        ->has(Tag::factory()->count(5))
        ->forAuthor()->forEditor()
        ->create([
            'name' => 'Fake Title',
            'description' => 'Ex enim reprehenderit ut ad do adipisicing excepteur ut aute eu deserunt.',
            'body' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
            'is_published' => true,
            'published_at' => '2021-06-17 22:05:34'
        ]);
        $this->assertNotNull($article);
        return $article->load('tags');
    }

    /** 
     * @test
     * @depends make_article
     */
    function article_has_name($article)
    {
        $this->assertEquals('Fake Title', $article->name);
    }

    /** 
     * @test
     * @depends make_article
     */
    function article_has_description($article)
    {
        $this->assertEquals('Ex enim reprehenderit ut ad do adipisicing excepteur ut aute eu deserunt.', $article->description);
    }

    /**
     * @test
     * @depends make_article
     */
    function article_has_body($article)
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $article->body);
    }

    /**
     * @test
     * @depends make_article
     */
    function article_is_published($article)
    {
        $this->assertTrue($article->is_published);
    }

    /**
     * @test
     * @depends make_article
     */
    function article_has_tags($article)
    {
        $this->assertCount(5, $article->tags);
    }

    /**
     * @test
     * @depends make_article
     */
    function article_has_author($article)
    {
        $this->assertNotNull($article->author_id);
    }

    /**
     * @test
     * @depends make_article
     */
    function article_has_editor($article)
    {
        $this->assertNotNull($article->editor_id);
    }
}