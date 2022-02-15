<?php

namespace Rancor\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Rancor\DB\Factories\PermissionFactory;
use App\Models\User;

class Permission extends Model
{
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
}
