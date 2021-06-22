<?php

namespace AndrykVP\Rancor\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Permission extends Model
{
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
}
