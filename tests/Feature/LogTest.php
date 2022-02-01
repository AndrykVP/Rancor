<?php

namespace AndrykVP\Rancor\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Audit\Models\AwardLog;
use AndrykVP\Rancor\Audit\Models\BanLog;
use AndrykVP\Rancor\Audit\Models\EntryLog;
use AndrykVP\Rancor\Audit\Models\IPLog;
use AndrykVP\Rancor\Audit\Models\NodeLog;
use AndrykVP\Rancor\Audit\Models\UserLog;

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
   public function empty_logs_database()
   {
   }
}