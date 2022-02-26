<?php

namespace Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Rancor\Audit\Contracts\LogContract;
use Rancor\DB\Factories\NodeLogFactory;
use Rancor\Holocron\Models\Node;

class NodeLog extends Model implements LogContract
{
<<<<<<< HEAD
	use HasFactory;

	/**
	 * Defines the table name
	 * 
	 * @var string
	 */
	protected $table = 'changelog_nodes';

	/**
	 * Relationship to User model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function creator()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	/**
	 * Relationship to Node model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function node()
	{
		return $this->belongsTo(Node::class)->withoutGlobalScope('access');
	}

	/**
	 * Method to render Log message in views
	 * 
	 * @return string
	 */
	public function message()
	{
		return "Node \"{$this->node->name}\" has been modified by {$this->creator->name}";
	}

	/**
	 * Create a new factory instance for the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	protected static function newFactory()
	{
		return NodeLogFactory::new();
	}
=======
   use HasFactory;

   protected $table = 'changelog_nodes';

   public function creator(): BelongsTo
   {
      return $this->belongsTo(User::class, 'updated_by');
   }

   public function node(): BelongsTo
   {
      return $this->belongsTo(Node::class)->withoutGlobalScope('access');
   }

   public function message(): string
   {
      return 'Node "' . $this->node->name . '" has been modified by ' . $this->creator->name;
   }

   protected static function newFactory(): Factory
   {
      return NodeLogFactory::new();
   }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
