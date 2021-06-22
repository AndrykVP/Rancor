<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Holocron\Models\Collection;
use AndrykVP\Rancor\Holocron\Models\Node;
use AndrykVP\Rancor\Tests\TestCase;
use App\Models\User;

class CollectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_collection()
    {
        $collection = Collection::factory()
        ->has(Node::factory()->forAuthor()->count(5))
        ->create([
            'name' => 'Fake Title',
            'description' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
            'slug' => 'lorem'
        ]);
        $this->assertNotNull($collection);
        return $collection->load('nodes');
    }

    /** 
     * @test
     * @depends make_collection
     */
    function collection_has_name($collection)
    {
        $this->assertEquals('Fake Title', $collection->name);
    }

    /**
     * @test
     * @depends make_collection
     */
    function collection_has_description($collection)
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $collection->description);
    }

    /**
     * @test
     * @depends make_collection
     */
    function collection_has_slug($collection)
    {
        $this->assertEquals('lorem', $collection->slug);
    }

    /**
     * @test
     * @depends make_collection
     */
    function collection_has_nodes($collection)
    {
        $this->assertNotEmpty($collection->nodes);
    }
}