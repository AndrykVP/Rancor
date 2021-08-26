<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Scanner\Models\TerritoryType;
use AndrykVP\Rancor\Tests\TestCase;

class TerritoryTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_territory_type()
    {
        $territory_type = TerritoryType::factory()
        ->create([
            'name' => 'Fake Title',
            'image' => 'http://www.example.com/image.png',
        ]);
        $this->assertNotNull($territory_type);
        return $territory_type;
    }

    /** 
     * @test
     * @depends make_territory_type
     */
    function territory_type_has_name($territory_type)
    {
        $this->assertEquals('Fake Title', $territory_type->name);
    }

    /** 
     * @test
     * @depends make_territory_type
     */
    function territory_type_has_image($territory_type)
    {
        $this->assertEquals('http://www.example.com/image.png', $territory_type->image);
    }
}