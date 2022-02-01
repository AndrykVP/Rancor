<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Audit\Models\NodeLog;
use AndrykVP\Rancor\Tests\TestCase;

class NodeLogModelTest extends TestCase
{
   use RefreshDatabase;

   protected $log;

   public function setUp(): void
   {
      parent::setUp();

      $log = NodeLog::factory()
      ->create([
         'old_name' => 'Anim aute irure ut incididunt',
         'old_body' => 'Voluptate laborum duis dolor quis esse exercitation et minim. Irure amet dolor mollit ut deserunt eu ullamco fugiat sint. Nulla aliquip proident exercitation enim laborum ullamco.'
      ]);
      
      $this->assertNotNull($log);
      $this->log = $log->load('Node', 'user', 'creator');
   }

   /** 
    * @test
    */
   function node_log_has_old_name()
   {
      $this->assertEquals('Anim aute irure ut incididunt', $this->log->old_name);
   }

   /** 
    * @test
    */
   function node_log_has_old_body()
   {
      $this->assertEquals('Voluptate laborum duis dolor quis esse exercitation et minim. Irure amet dolor mollit ut deserunt eu ullamco fugiat sint. Nulla aliquip proident exercitation enim laborum ullamco.', $this->log->old_body);
   }

   /** 
    * @test
    */
   function node_log_has_node()
   {
      $this->assertNotEmpty($this->log->node);
      $this->assertEquals(1, $this->log->node->id);
   }
   /** 
    * @test
    */
   function node_log_has_creator()
   {
      $this->assertNotEmpty($this->log->creator);
      $this->assertEquals(1, $this->log->creator->id);
   }

   /** 
    * @test
    */
   function node_log_has_message()
   {
      $this->assertNotNull($this->log->message());
   }
}