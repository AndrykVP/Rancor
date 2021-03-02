<?php

namespace AndrykVP\Rancor\Auth;

use Illuminate\Database\Eloquent\Model;

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
        return $this->morphedByMany('App\User','permissible', 'rancor_permissibles');
    }

    /**
     * Relationship to Role model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->morphedByMany('AndrykVP\Rancor\Auth\Role','permissible', 'rancor_permissibles');
    }
}
