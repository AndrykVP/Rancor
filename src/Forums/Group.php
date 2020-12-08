<?php

namespace AndrykVP\Rancor\Forums;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
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
    protected $fillable = [ 'name', 'description', 'color' ];

    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $hidden = ['pivot'];

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->morphedByMany('App\User','groupable','forum_groupables')->withTimestamps();
    }

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function boards()
    {
        return $this->morphedByMany('AndrykVP\Rancor\Forums\Board','groupable','forum_groupables')->withTimestamps();
    }

    /**
     * Relationship to Category model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->morphedByMany('AndrykVP\Rancor\Forums\Category','groupable','forum_groupables')->withTimestamps();
    }
}
