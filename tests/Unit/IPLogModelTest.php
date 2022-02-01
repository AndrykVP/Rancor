<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Audit\Enums\Access;
use AndrykVP\Rancor\Audit\Models\IPLog;
use AndrykVP\Rancor\Tests\TestCase;

class IPLogModelTest extends TestCase
{
   use RefreshDatabase;

   protected $log;

   public function setUp(): void
   {
      parent::setUp();

      $log = IPLog::factory()
      ->create([
         'ip_address' => '127.0.0.1',
         'user_agent' => 'Mozilla',
         'type' => Access::LOGIN
      ]);
      
      $this->assertNotNull($log);
      $this->log = $log->load('user', 'creator');
   }

   /** @test */
   function ip_log_has_ip_address()
   {
      $this->assertEquals('127.0.0.1', $this->log->ip_address);
   }

   /** @test */
   function ip_log_has_user_agent()
   {
      $this->assertEquals('Mozilla', $this->log->user_agent);
   }

   /** @test */
   function ip_log_has_type()
   {
      $this->assertEquals(Access::LOGIN, $this->log->type);
      $this->assertEquals('login', $this->log->type->value);
      $this->assertEquals('has logged in', $this->log->type->message());
   }

   /** 
    * @test
    */
   function ip_log_has_user()
   {
      $this->assertNotEmpty($this->log->user);
      $this->assertEquals(1, $this->log->user->id);
   }
}