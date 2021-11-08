<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Scanner\Models\TerritoryType;
use AndrykVP\Rancor\Tests\TestCase;

class TerritoryTypeModelTest extends TestCase
{
    use RefreshDatabase;

    protected $territory_type;

    public function setUp(): void
    {
        parent::setUp();

        $territory_type = TerritoryType::factory()
        ->create([
            'name' => 'Fake Title',
            'image' => 'http://www.example.com/image.png',
        ]);

        $this->assertNotNull($territory_type);
        $this->territory_type = $territory_type;
    }

    /** 
     * @test
     */
    function territory_type_has_name()
    {
        $this->assertEquals('Fake Title', $this->territory_type->name);
    }

    /** 
     * @test
     */
    function territory_type_has_image()
    {
        $this->assertEquals('http://www.example.com/image.png', $this->territory_type->image);
    }
}