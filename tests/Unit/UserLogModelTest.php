<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Audit\Models\UserLog;
use AndrykVP\Rancor\Tests\TestCase;

class UserLogModelTest extends TestCase
{
   use RefreshDatabase;

   protected $log;

   public function setUp(): void
   {
      parent::setUp();

      $log = UserLog::factory()
      ->create([
         'action' => 'Esse voluptate irure magna',
         'color' => 'red'
      ]);
      
      $this->assertNotNull($log);
      $this->log = $log->load('user', 'creator');
   }

   /** @test */
   function user_log_has_action()
   {
      $this->assertEquals('Esse voluptate irure magna', $this->log->action);
   }

   /** @test */
   function user_log_has_color()
   {
      $this->assertEquals('red', $this->log->color);
   }

   /** 
    * @test
    */
   function user_log_has_user()
   {
      $this->assertNotEmpty($this->log->user);
      $this->assertEquals(1, $this->log->user->id);
   }

   /** 
    * @test
    */
   function user_log_has_creator()
   {
      $this->assertNotEmpty($this->log->creator);
      $this->assertEquals(2, $this->log->crreator->id);
   }

   /** 
    * @test
    */
   function user_log_has_message()
   {
      $this->assertNotNull($this->log->message());
   }
}