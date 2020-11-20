<?php

namespace AndrykVP\Rancor\Forums;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'title', 'color' ];

    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'forum_categories';

    /**
     * Relationship to Group model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function group()
    {
        return $this->belongsToMany('AndrykVP\Rancor\Forums\Group');
    }

    /**
     * Relationship to Group model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function boards()
    {
        return $this->hasMany('AndrykVP\Rancor\Forums\Board');
    }
}
