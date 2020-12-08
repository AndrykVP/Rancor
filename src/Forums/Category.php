<?php

namespace AndrykVP\Rancor\Forums;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'forum_categories';
    
    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'title', 'color', 'slug', 'order' ];

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boards()
    {
        return $this->hasMany('AndrykVP\Rancor\Forums\Board')->orderBy('order');
    }

    /**
     * Relationship to Group model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->morphToMany('AndrykVP\Rancor\Forums\Group','groupable','forum_groupables')->withTimestamps();
    }
}
