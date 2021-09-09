<?php

namespace AndrykVP\Rancor\Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Holocron\Models\Node;
use App\Models\User;

class NodeAPITest extends TestCase
{
   use RefreshDatabase;

   protected $nodes, $user, $admin;
   
   public function setUp(): void
   {
      parent::setUp();

      // Make sure we start without Nodes
      $this->assertDatabaseCount('holocron_nodes', 0);

      // Initialize Test DB
      $this->nodes = Node::factory() 
                     ->forAuthor()
                     ->public()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_node_api_index()
   {
      $response = $this->getJson(route('api.holocron.nodes.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_node_api_index()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.holocron.nodes.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_node_api_index()
   {
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.holocron.nodes.index'));
      $response->assertSuccessful()->assertJsonCount(3, 'data');
   }

   /** @test */
   function guest_cannot_access_node_api_show()
   {
      $node = $this->nodes->random();
      $response = $this->getJson(route('api.holocron.nodes.show', $node));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_node_api_show()
   {
      $node = $this->nodes->random();
      $response = $this->actingAs($this->user, 'api')
                  ->getJson(route('api.holocron.nodes.show', $node));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_node_api_show()
   {
      $node = $this->nodes->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->getJson(route('api.holocron.nodes.show', $node));
      $response->assertSuccessful()->assertJson([
         'data' => [
            'id' => $node->id,
            'name' => $node->name,
            'body' => clean($node->body),
            'is_public' => $node->is_public,
         ]
      ]);
   }

   /** @test */
   function guest_cannot_access_node_api_store()
   {
      $response = $this->postJson(route('api.holocron.nodes.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_node_api_store()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.holocron.nodes.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_node_api_store()
   {
      $node = Node::factory()->make();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.holocron.nodes.store'), $node->toArray());
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Node "'. $node->name .'" has been created'
      ]);
   }

   /** @test */
   function guest_cannot_access_node_api_update()
   {
      $node = $this->nodes->random();
      $response = $this->patchJson(route('api.holocron.nodes.update', $node), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_node_api_update()
   {
      $node = $this->nodes->random();
      $response = $this->actingAs($this->user, 'api')
                  ->patchJson(route('api.holocron.nodes.update', $node), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_node_api_update()
   {
      $node = $this->nodes->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->patchJson(route('api.holocron.nodes.update', $node), [
                     'id' => $node->id,
                     'name' => 'Updated Node',
                     'body' => 'Updated Node Body',
                     'is_public' => true
                  ]);
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Node "Updated Node" has been updated'
      ]);
   }

   /** @test */
   function guest_cannot_access_node_api_destroy()
   {
      $node = $this->nodes->random();
      $response = $this->deleteJson(route('api.holocron.nodes.destroy', $node));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_node_api_destroy()
   {
      $node = $this->nodes->random();
      $response = $this->actingAs($this->user, 'api')
                  ->deleteJson(route('api.holocron.nodes.destroy', $node));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_node_api_destroy()
   {
      $node = $this->nodes->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->deleteJson(route('api.holocron.nodes.destroy', $node));
      $response->assertSuccessful()->assertExactJson([
         'message' => 'Node "'. $node->name .'" has been deleted'
      ]);
   }

   /** @test */
   function guest_cannot_access_node_api_search()
   {
      $response = $this->postJson(route('api.holocron.nodes.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function user_cannot_access_node_api_search()
   {
      $response = $this->actingAs($this->user, 'api')
                  ->postJson(route('api.holocron.nodes.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_node_api_search()
   {
      $node = $this->nodes->random();
      $response = $this->actingAs($this->admin, 'api')
                  ->postJson(route('api.holocron.nodes.search', [
                     'attribute' => 'name',
                     'value' => $node->name,
                  ]));
      $response->assertSuccessful()->assertJsonFragment(['id' => $node->id]);
   }
}