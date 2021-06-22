<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Structure\Models\Type;
use AndrykVP\Rancor\Tests\TestCase;

class TypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_type()
    {
        $type = Type::factory()
        ->hasAwards(3)
        ->create([
            'name' => 'Fake Title',
            'description' => 'Ex enim reprehenderit ut ad do adipisicing excepteur ut aute eu deserunt.',
        ]);
        $this->assertNotNull($type);
        return $type->load('awards');
    }

    /** 
     * @test
     * @depends make_type
     */
    function type_has_name($type)
    {
        $this->assertEquals('Fake Title', $type->name);
    }

    /** 
     * @test
     * @depends make_type
     */
    function type_has_description($type)
    {
        $this->assertEquals('Ex enim reprehenderit ut ad do adipisicing excepteur ut aute eu deserunt.', $type->description);
    }

    /**
     * @test
     * @depends make_type
     */
    function type_has_awards($type)
    {
        $this->assertCount(3, $type->awards);
    }
}