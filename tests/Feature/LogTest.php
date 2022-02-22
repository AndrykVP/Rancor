<?php

namespace Rancor\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Tests\TestCase;
use Rancor\Audit\Models\AwardLog;
use Rancor\Audit\Models\BanLog;
use Rancor\Audit\Models\EntryLog;
use Rancor\Audit\Models\IPLog;
use Rancor\Audit\Models\NodeLog;
use Rancor\Audit\Models\UserLog;

class LogTest extends TestCase
{
   use RefreshDatabase;

   protected $awards, $bans, $entries, $ips, $nodes, $users;

   public function setUp(): void
   {
      parent::setUp();

      // Initialize Database
      $this->awards = AwardLog::factory()->count(5)->create();
      $this->bans = BanLog::factory()->count(5)->create();
      $this->entries = EntryLog::factory()->count(5)->create();
      $this->ips = IPLog::factory()->count(5)->create();
      $this->nodes = NodeLog::factory()->count(5)->create();
      $this->users = UserLog::factory()->count(5)->create();
   }

   /** @test */
   public function count_award_logs()
   {
      $this->assertCount(5, $this->awards);
   }
}