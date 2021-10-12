<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Scanner\Models\Entry;
use AndrykVP\Rancor\Tests\TestCase;

class EntryTest extends TestCase
{
    use RefreshDatabase;

    protected $entry;

    public function setUp(): void
    {
        parent::setUp();

        $entry = Entry::factory()
        ->forContributor()
        ->create([
            'type' => 'Star Destroyer',
            'name' => 'Fake Title',
            'owner' => 'Darth Vader',
            'last_seen' => '2021-06-17 22:05:34',
            'alliance' => 1,
        ]);
        
        $this->assertNotNull($entry);
        $this->entry = $entry;
    }

    /** 
     * @test
     */
    function entry_has_type()
    {
        $this->assertEquals('Star Destroyer', $this->entry->type);
    }

    /** 
     * @test
     */
    function entry_has_name()
    {
        $this->assertEquals('Fake Title', $this->entry->name);
    }

    /** 
     * @test
     */
    function entry_has_owner()
    {
        $this->assertEquals('Darth Vader', $this->entry->owner);
    }

    /** 
     * @test
     */
    function entry_has_alliance()
    {
        $this->assertEquals(1, $this->entry->alliance);
        $this->assertEquals('Friend', $this->entry->alliance_text);
    }

    /**
     * @test
     */
    function entry_has_position()
    {
        $this->assertNotNull($this->entry->position['orbit']['x']);
        $this->assertNotNull($this->entry->position['orbit']['y']);
    }

    /** 
     * @test
     */
    function entry_has_last_seen_date()
    {
        $this->assertEquals('2021-06-17 22:05:34', $this->entry->last_seen);
    }

    /**
     * @test
     */
    function entry_has_contributor()
    {
        $this->assertNotNull($this->entry->updated_by);
    }

    /**
     * @test
     */
    function entry_has_territory()
    {
        $this->assertNotNull($this->entry->territory_id);
    }
}