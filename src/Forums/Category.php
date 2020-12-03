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
     * Relationship to Group model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function boards()
    {
        return $this->hasMany('AndrykVP\Rancor\Forums\Board')->orderBy('order');
    }
}
