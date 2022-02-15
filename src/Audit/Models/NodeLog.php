<?php

namespace Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Rancor\Audit\Contracts\LogContract;
use Rancor\DB\Factories\NodeLogFactory;
use Rancor\Holocron\Models\Node;

class NodeLog extends Model implements LogContract
{
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
}
