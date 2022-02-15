<?php

namespace Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Holocron\Models\Collection;
use Rancor\Holocron\Models\Node;
use Rancor\Tests\TestCase;

class NodeModelTest extends TestCase
{
    use RefreshDatabase;

    protected $node;

    public function setUp(): void
    {
        parent::setUp();

        $node = Node::factory()
        ->has(Collection::factory()->count(5))
        ->forAuthor()->forEditor()
        ->create([
            'name' => 'Fake Title',
            'body' => 'Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.',
            'is_public' => true
        ]);
        
        $this->assertNotNull($node);
        $this->node = $node->load('collections');
    }

    /** 
     * @test
     */
    function node_has_name()
    {
        $this->assertEquals('Fake Title', $this->node->name);
    }

    /**
     * @test
     */
    function node_has_body()
    {
        $this->assertEquals('Voluptate dolor cupidatat sit sint ea Lorem excepteur sunt quis ipsum anim ipsum. Do ullamco sit velit commodo magna sint est labore enim sint. Non incididunt deserunt deserunt tempor minim velit id duis proident nostrud ad ad exercitation.', $this->node->body);
    }

    /**
     * @test
     */
    function node_is_public()
    {
        $this->assertTrue($this->node->is_public);
    }

    /**
     * @test
     */
    function node_has_collections()
    {
        $this->assertCount(5, $this->node->collections);
    }
}