<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Audit\Models\BanLog;
use AndrykVP\Rancor\Tests\TestCase;

class BanLogModelTest extends TestCase
{
    use RefreshDatabase;

    protected $ban;

    public function setUp(): void
    {
        parent::setUp();

        $ban = BanLog::factory()
        ->forUser()
        ->forCreator()
        ->create([
            'reason' => 'Ban Hammer Test',
            'status' => true,
        ]);
        
        $this->assertNotNull($ban);
        $this->ban = $ban->load('user', 'creator');
    }

    /** 
     * @test
     */
    function ban_has_reason()
    {
        $this->assertEquals('Ban Hammer Test', $this->ban->reason);
    }

    /** 
     * @test
     */
    function ban_has_status()
    {
        $this->assertTrue($this->ban->status);
    }
    
    /**
     * @test
     */
    function ban_has_user()
    {
        $this->assertNotEmpty($this->ban->user);
        $this->assertEquals(1, $this->ban->user_id);
    }
    
    /**
     * @test
     */
    function ban_has_creator()
    {
        $this->assertNotEmpty($this->ban->creator);
        $this->assertEquals(2, $this->ban->updated_by);
    }
}