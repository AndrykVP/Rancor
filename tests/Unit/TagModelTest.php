<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\News\Models\Tag;
use AndrykVP\Rancor\News\Models\Article;
use AndrykVP\Rancor\Tests\TestCase;

class TagModelTest extends TestCase
{
    use RefreshDatabase;

    protected $tag;

    public function setUp(): void
    {
        parent::setUp();

        $tag = Tag::factory()
        ->has(Article::factory()->forAuthor()->count(10))
        ->create([
            'name' => 'Fake Title'
        ]);

        $this->assertNotNull($tag);
        $this->tag = $tag->load('articles');
    }

    /** 
     * @test
     */
    function tag_has_name()
    {
        $this->assertEquals('Fake Title', $this->tag->name);
    }

    /**
     * @test
     */
    function tag_has_articles()
    {
        $this->assertCount(10, $this->tag->articles);
    }
}