<?php

namespace Rancor\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Rancor\DB\Factories\RoleFactory;
use App\Models\User;

class Role extends Model
{
	use HasFactory;
	
	/**
	 * Defines the table name
	 * 
	 * @var string
	 */
	protected $table = 'rancor_roles';

	/**
	 * Attributes available for mass assignment
	 * 
	 * @var array
	 */
	protected $fillable = [ 'name', 'description' ];

	/**
	 * Relationship to Permission model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function permissions()
	{
		return $this->morphToMany(Permission::class, 'permissible', 'rancor_permissibles')->withTimestamps();
	}

	/**
	 * Relationship to User model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->belongsToMany(User::class, 'rancor_role_user')->withTimestamps();
	}

	/**
	 * Create a new factory instance for the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	protected static function newFactory()
	{
		return RoleFactory::new();
	}
}
