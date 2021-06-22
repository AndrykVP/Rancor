<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Holocron\Models\Collection;
use AndrykVP\Rancor\Holocron\Models\Node;
use AndrykVP\Rancor\Tests\TestCase;

class NodeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_node()
    {
        $node = Node::factory()
        ->has(Collection::factory()->count(5))
        ->forAuthor()->forEditor()
        ->create([
            'name' => 'Fake Title',
            'body' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
            'is_public' => true
        ]);
        $this->assertNotNull($node);
        return $node->load('collections');
    }

    /** 
     * @test
     * @depends make_node
     */
    function node_has_name($node)
    {
        $this->assertEquals('Fake Title', $node->name);
    }

    /**
     * @test
     * @depends make_node
     */
    function node_has_body($node)
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $node->body);
    }

    /**
     * @test
     * @depends make_node
     */
    function node_is_public($node)
    {
        $this->assertTrue($node->is_public);
    }

    /**
     * @test
     * @depends make_node
     */
    function node_has_collections($node)
    {
        $this->assertCount(5, $node->collections);
    }
}