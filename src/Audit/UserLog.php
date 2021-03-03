<?php

namespace AndrykVP\Rancor\Audit;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'changelog_users';

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Relationship to Role model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function creator()
    {
        return $this->belongsTo('App\User','updated_by');
    }
}
