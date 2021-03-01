<?php

namespace AndrykVP\Rancor\Auth;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
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
        return $this->morphToMany('AndrykVP\Rancor\Auth\Permission', 'permissible')->withTimestamps();
    }

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
