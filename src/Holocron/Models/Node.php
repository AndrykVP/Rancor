<?php

namespace Rancor\Holocron\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Rancor\Audit\Events\NodeUpdate;
use Rancor\DB\Factories\NodeFactory;
use Rancor\Package\Traits\Userstamps;

class Node extends Model
{
	use HasFactory, Userstamps;
	
	/**
	 * Defines the table name
	 * 
	 * @var string
	 */
	protected $table = 'holocron_nodes';

	/**
	 * Attributes available for mass assignment
	 * 
	 * @var array
	 */
	protected $fillable = [ 'name', 'body', 'is_public', 'published_at' ];

	/**
	 * Attributes casted to native types
	 * 
	 * @var array
	 */
	protected $casts = [
		'is_public' => 'boolean',
		'published_at' => 'datetime',
	];

	/**
	 * Defines the table name
	 * 
	 * @var string
	 */
	protected $hidden = ['pivot'];

	/**
	 * The event map for the model.
	 *
	 * @var array
	 */
	protected $dispatchesEvents = [
		'updating' => NodeUpdate::class,
	];

	/**
	 * The "booted" method of the model.
	 *
	 * @return void
	 */
	protected static function booted()
	{
		static::addGlobalScope('access', function (Builder $builder) {
			if(Auth::check() && Auth::user()->can('viewAny', Node::class))
			{
				$builder;
			}
			else
			{
				$builder->where('is_public', true);
			}
		});
	}

	/**
	 * Relationship to User model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function author()
	{
		return $this->belongsTo(User::class, 'created_by');
	}

	/**
	 * Relationship to User model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function editor()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	/**
	 * Relationship to Collection model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function collections()
	{
		return $this->belongsToMany(Collection::class, 'holocron_collection_node')->withTimestamps();
	}
	
	/**
	 * Create a new factory instance for the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	protected static function newFactory()
	{
		return NodeFactory::new();
	}
}
