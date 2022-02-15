<?php

namespace Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Structure\Models\AwardType;
use Rancor\Tests\TestCase;

class AwardTypeModelTest extends TestCase
{
    use RefreshDatabase;

    protected $type;

    public function setUp(): void
    {
        parent::setUp();

        $type = AwardType::factory()
        ->hasAwards(3)
        ->create([
            'name' => 'Fake Title',
            'description' => 'Ex enim reprehenderit ut ad do adipisicing excepteur ut aute eu deserunt.',
        ]);
        
        $this->assertNotNull($type);
        $this->type = $type->load('awards');
    }

    /** 
     * @test
     */
    function type_has_name()
    {
        $this->assertEquals('Fake Title', $this->type->name);
    }

    /** 
     * @test
     */
    function type_has_description()
    {
        $this->assertEquals('Ex enim reprehenderit ut ad do adipisicing excepteur ut aute eu deserunt.', $this->type->description);
    }

    /**
     * @test
     */
    function type_has_awards()
    {
        $this->assertCount(3, $this->type->awards);
    }
}