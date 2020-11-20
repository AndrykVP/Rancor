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
        return $this->belongsToMany('App\User','forum_group_user')->withTimestamps();
    }

    /**
     * Relationship to Categories model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->belongsToMany('AndrykVP\Rancor\Forums\Category','forum_category_group')->withTimestamps();
    }
}
