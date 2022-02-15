<?php

namespace Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Holocron\Models\Collection;
use Rancor\Holocron\Models\Node;
use Rancor\Tests\TestCase;

class CollectionModelTest extends TestCase
{
    use RefreshDatabase;

    protected $collection;

    public function setUp(): void
    {
        parent::setUp();

        $collection = Collection::factory()
        ->has(Node::factory()->count(5)->forAuthor()->public())
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
            'slug' => 'lorem'
        ]);
        
        $this->assertNotNull($collection);
        $this->collection = $collection->load('nodes');
    }

    /** 
     * @test
     */
    function collection_has_name()
    {
        $this->assertEquals('Fake Title', $this->collection->name);
    }

    /**
     * @test
     */
    function collection_has_description()
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $this->collection->description);
    }

    /**
     * @test
     */
    function collection_has_slug()
    {
        $this->assertEquals('lorem', $this->collection->slug);
    }

    /**
     * @test
     */
    function collection_has_nodes()
    {
        $this->assertCount(5, $this->collection->nodes);
    }
}