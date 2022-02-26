<?php

namespace Rancor\Auth\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
<<<<<<< HEAD
use Rancor\DB\Factories\PermissionFactory;
=======
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use AndrykVP\Rancor\DB\Factories\PermissionFactory;
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
use App\Models\User;

class Permission extends Model
{
<<<<<<< HEAD
	use HasFactory;
	
	/**
	 * Defines the table name
	 * 
	 * @var string
	 */
	protected $table = 'rancor_permissions';

	/**
	 * Attributes available for mass assignment
	 * 
	 * @var array
	 */
	protected $fillable = [ 'name', 'description' ];

	/**
	 * Relationship to User model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->morphedByMany(User::class,'permissible', 'rancor_permissibles');
	}

	/**
	 * Relationship to Role model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles()
	{
		return $this->morphedByMany(Role::class,'permissible', 'rancor_permissibles');
	}

	/**
	 * Create a new factory instance for the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	protected static function newFactory()
	{
		return PermissionFactory::new();
	}
=======
    use HasFactory;
    
    protected $table = 'rancor_permissions';

    protected $fillable = [
        'name',
        'description'
    ];

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class,'permissible', 'rancor_permissibles');
    }

    public function roles(): MorphToMany
    {
        return $this->morphedByMany(Role::class,'permissible', 'rancor_permissibles');
    }

    protected static function newFactory(): Factory
    {
        return PermissionFactory::new();
    }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
