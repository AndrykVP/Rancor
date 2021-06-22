<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Scanner\Models\Entry;
use AndrykVP\Rancor\Tests\TestCase;

class EntryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_entry()
    {
        $entry = Entry::factory()
        ->forContributor()
        ->create([
            'type' => 'Star Destroyer',
            'name' => 'Fake Title',
            'owner' => 'Darth Vader',
            'last_seen' => '2021-06-17 22:05:34'
        ]);
        $this->assertNotNull($entry);
        return $entry;
    }

    /** 
     * @test
     * @depends make_entry
     */
    function entry_has_type($entry)
    {
        $this->assertEquals('Star Destroyer', $entry->type);
    }

    /** 
     * @test
     * @depends make_entry
     */
    function entry_has_name($entry)
    {
        $this->assertEquals('Fake Title', $entry->name);
    }

    /** 
     * @test
     * @depends make_entry
     */
    function entry_has_owner($entry)
    {
        $this->assertEquals('Darth Vader', $entry->owner);
    }

    /**
     * @test
     * @depends make_entry
     */
    function entry_has_position($entry)
    {
        $this->assertNotNull($entry->position['galaxy']['x']);
        $this->assertNotNull($entry->position['galaxy']['y']);
        $this->assertNotNull($entry->position['system']['x']);
        $this->assertNotNull($entry->position['system']['y']);
    }

    /** 
     * @test
     * @depends make_entry
     */
    function entry_has_last_seen_date($entry)
    {
        $this->assertEquals('2021-06-17 22:05:34', $entry->last_seen);
    }

    /**
     * @test
     * @depends make_entry
     */
    function entry_has_contributor($entry)
    {
        $this->assertNotNull($entry->updated_by);
    }
}