<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Audit\Models\EntryLog;
use AndrykVP\Rancor\Scanner\Enums\Alliance;
use AndrykVP\Rancor\Tests\TestCase;

class EntryLogModelTest extends TestCase
{
   use RefreshDatabase;

   protected $log;

   public function setUp(): void
   {
      parent::setUp();

      $log = EntryLog::factory()
      ->create([
         'old_type' => 'Esse do esse',
         'old_name' => 'Millenium Falcon',
         'old_owner' => 'Han Solo',
         'old_alliance' => Alliance::FRIEND,
      ]);
      
      $this->assertNotNull($log);
      $this->log = $log->load('entry', 'creator');
   }

   /** @test */
   function entry_log_has_old_type()
   {
      $this->assertEquals('Esse do esse', $this->log->old_type);
   }

   /** @test */
   function entry_log_has_old_name()
   {
      $this->assertEquals('Millenium Falcon', $this->log->old_name);
   }

   /** @test */
   function entry_log_has_old_owner()
   {
      $this->assertEquals('Han Solo', $this->log->old_owner);
   }

   /** @test */
   function entry_log_has_old_territory()
   {
      $this->assertEquals(1, $this->log->old_territory_id);
   }

   /** @test */
   function entry_log_has_old_alliance()
   {
      $this->assertEquals(Alliance::FRIEND, $this->log->old_alliance);
      $this->assertEquals('Friend', $this->log->old_alliance->value);
   }

   /** 
    * @test
    */
   function entry_log_has_entry()
   {
      $this->assertNotEmpty($this->log->entry);
      $this->assertEquals(1, $this->log->entry->id);
   }

   /** 
    * @test
    */
   function entry_log_has_creator()
   {
      $this->assertNotEmpty($this->log->creator);
      $this->assertEquals(1, $this->log->creator->id);
   }

   /** 
    * @test
    */
   function entry_log_has_message()
   {
      $this->assertNotNull($this->log->message());
   }
}