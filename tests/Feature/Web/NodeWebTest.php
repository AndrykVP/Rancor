<?php

namespace AndrykVP\Rancor\Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\Holocron\Models\Node;
use App\Models\User;

class NodeWebTest extends TestCase
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
                     ->hasCollections(3)
                     ->public()
                     ->count(3)
                     ->create();
      $this->user = User::factory()->create();
      $this->admin = User::factory()->create(['is_admin' => true]);
   }

   /** @test */
   function guest_cannot_access_node_index()
   {
      $response = $this->get(route('admin.nodes.index'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_node_index()
   {
      $response = $this->actingAs($this->user)
                  ->get(route('admin.nodes.index'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_node_index()
   {
      $node = $this->nodes->first();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.nodes.index'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($node->id)
               ->assertSee($node->name);
   }

   /** @test */
   function guest_cannot_access_node_show()
   {
      $node = $this->nodes->random();
      $response = $this->get(route('admin.nodes.show', $node));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_node_show()
   {
      $node = $this->nodes->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.nodes.show', $node));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_node_show()
   {
      $node = $this->nodes->random()->load('author');
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.nodes.show', $node));
      $response->assertSuccessful()
               ->assertViewIs('rancor::show.node')
               ->assertSee($node->id)
               ->assertSee($node->name)
               ->assertSee($node->author->name);
   }

   /** @test */
   function guest_cannot_access_node_create()
   {
      $response = $this->get(route('admin.nodes.create'));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_node_create()
   {
      $response = $this->actingAs($this->user)->get(route('admin.nodes.create'));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_node_create()
   {
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.nodes.create'));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.create');
   }

   /** @test */
   function guest_cannot_access_node_store()
   {
      $response = $this->post(route('admin.nodes.store'), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_node_store()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.nodes.store'), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_node_store()
   {
      $node = Node::factory()->make();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.nodes.store'), $node->toArray());
      $response->assertRedirect(route('admin.nodes.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Node',
                     'name' => $node->name,
                     'action' => 'created',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_node_edit()
   {
      $node = $this->nodes->random();
      $response = $this->get(route('admin.nodes.edit', $node));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_node_edit()
   {
      $node = $this->nodes->random();
      $response = $this->actingAs($this->user)
                  ->get(route('admin.nodes.edit', $node));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_node_edit()
   {
      $node = $this->nodes->random();
      $response = $this->actingAs($this->admin)
                  ->get(route('admin.nodes.edit', $node));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.edit')
               ->assertSee($node->id)
               ->assertSee($node->name)
               ->assertSee($node->body);
   }

   /** @test */
   function guest_cannot_access_node_update()
   {
      $node = $this->nodes->random();
      $response = $this->patch(route('admin.nodes.update', $node), []);
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_node_update()
   {
      $node = $this->nodes->random();
      $response = $this->actingAs($this->user)
                  ->patch(route('admin.nodes.update', $node), []);
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_node_update()
   {
      $node = $this->nodes->random();
      $response = $this->actingAs($this->admin)
                  ->patch(route('admin.nodes.update', $node), [
                     'id' => $node->id,
                     'name' => 'Updated Node',
                     'body' => 'Lorem ipsum dolot',
                     'is_public' => true,
                  ]);
      $response->assertRedirect(route('admin.nodes.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Node',
                     'name' => 'Updated Node',
                     'action' => 'updated',
                  ]
               ]);
   }
   
   /** @test */
   function guest_cannot_access_node_destroy()
   {
      $node = $this->nodes->random();
      $response = $this->delete(route('admin.nodes.destroy', $node));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_node_destroy()
   {
      $node = $this->nodes->random();
      $response = $this->actingAs($this->user)
                  ->delete(route('admin.nodes.destroy', $node));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_node_destroy()
   {
      $node = $this->nodes->random();
      $response = $this->actingAs($this->admin)
                  ->delete(route('admin.nodes.destroy', $node));
      $response->assertRedirect(route('admin.nodes.index'))
               ->assertSessionHas('alert', [
                  'message' => [
                     'model' => 'Node',
                     'name' => $node->name,
                     'action' => 'deleted',
                  ]
               ]);
   }

   /** @test */
   function guest_cannot_access_node_search()
   {
      $response = $this->post(route('admin.nodes.search', []));
      $response->assertRedirect(route('login'));
   }

   /** @test */
   function user_cannot_access_node_search()
   {
      $response = $this->actingAs($this->user)
                  ->post(route('admin.nodes.search', []));
      $response->assertUnauthorized();
   }

   /** @test */
   function admin_can_access_node_search()
   {
      $node = $this->nodes->random();
      $response = $this->actingAs($this->admin)
                  ->post(route('admin.nodes.search', [
                     'attribute' => 'name',
                     'value' => $node->name,
                  ]));
      $response->assertSuccessful()
               ->assertViewIs('rancor::resources.index')
               ->assertSee($node->id)
               ->assertSee($node->name);
   }
}