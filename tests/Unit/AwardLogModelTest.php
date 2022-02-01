<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Audit\Models\AwardLog;
use AndrykVP\Rancor\Tests\TestCase;

class AwardLogModelTest extends TestCase
{
    use RefreshDatabase;

    protected $log;

    public function setUp(): void
    {
        parent::setUp();

        $log = AwardLog::factory()
        ->create([
            'action' => 1,
        ]);
        
        $this->assertNotNull($log);
        $this->log = $log->load('award', 'user', 'creator');
    }

    /** 
     * @test
     */
    function award_log_has_action()
    {
        $this->assertEquals(1, $this->log->action);
    }

    /** 
     * @test
     */
    function award_log_has_award()
    {
        $this->assertNotEmpty($this->log->award);
        $this->assertEquals(1, $this->log->award->id);
    }

    /** 
     * @test
     */
    function award_log_has_user()
    {
        $this->assertNotEmpty($this->log->user);
        $this->assertEquals(1, $this->log->user->id);
    }

    /** 
     * @test
     */
    function award_log_has_creator()
    {
        $this->assertNotEmpty($this->log->creator);
        $this->assertEquals(2, $this->log->creator->id);
    }

    /** 
     * @test
     */
    function award_log_has_message()
    {
        $this->assertNotNull($this->log->message());
    }
}