<?php

namespace Rancor\Forums\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Rancor\DB\Factories\GroupFactory;

class Group extends Model
{
	use HasFactory;
	
	/**
	 * Defines the table name
	 * 
	 * @var string
	 */
	protected $table = 'forum_groups';

	/**
	 * Attributes available for mass assignment
	 * 
	 * @var array
	 */
	protected $fillable = [ 'name', 'description' ];

	/**
	 * Defines the table name
	 * 
	 * @var string
	 */
	protected $hidden = ['pivot'];

	/**
	 * Relationship to User model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->morphedByMany(User::class, 'groupable', 'forum_groupables')->withTimestamps();
	}

	/**
	 * Relationship to Board model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function boards()
	{
		return $this->morphedByMany(Board::class, 'groupable', 'forum_groupables')->withTimestamps();
	}
	
	/**
	 * Create a new factory instance for the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	protected static function newFactory()
	{
		return GroupFactory::new();
	}
}
