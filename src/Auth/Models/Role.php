<?php

namespace Rancor\Auth\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
<<<<<<< HEAD
use Rancor\DB\Factories\RoleFactory;
=======
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use AndrykVP\Rancor\DB\Factories\RoleFactory;
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
use App\Models\User;

class Role extends Model
{
<<<<<<< HEAD
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
=======
    use HasFactory;

    protected $table = 'rancor_roles';

    protected $fillable = [
        'name',
        'description'
    ];

    public function permissions(): MorphToMany
    {
        return $this->morphToMany(Permission::class, 'permissible', 'rancor_permissibles')->withTimestamps();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'rancor_role_user')->withTimestamps();
    }

    protected static function newFactory(): Factory
    {
        return RoleFactory::new();
    }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
