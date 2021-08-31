<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\News\Models\Article;
use AndrykVP\Rancor\News\Models\Tag;
use AndrykVP\Rancor\Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    protected $article;

    public function setUp(): void
    {
        parent::setUp();

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
        $this->article = $article->load('tags');
    }

    /** 
     * @test
     */
    function article_has_name()
    {
        $this->assertEquals('Fake Title', $this->article->name);
    }

    /** 
     * @test
     */
    function article_has_description()
    {
        $this->assertEquals('Ex enim reprehenderit ut ad do adipisicing excepteur ut aute eu deserunt.', $this->article->description);
    }

    /**
     * @test
     */
    function article_has_body()
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $this->article->body);
    }

    /**
     * @test
     */
    function article_is_published()
    {
        $this->assertTrue($this->article->is_published);
    }

    /**
     * @test
     */
    function article_has_tags()
    {
        $this->assertCount(5, $this->article->tags);
    }

    /**
     * @test
     */
    function article_has_author()
    {
        $this->assertNotNull($this->article->author_id);
    }

    /**
     * @test
     */
    function article_has_editor()
    {
        $this->assertNotNull($this->article->editor_id);
    }
}