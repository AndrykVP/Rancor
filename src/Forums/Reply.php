<?php

namespace AndrykVP\Rancor\Forums;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'body', 'discussion_id', 'author_id' ];

    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'forum_replies';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_locked' => 'boolean',
    ];

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Relationship to Discussion model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discussion()
    {
        return $this->belongsTo('AndrykVP\Rancor\Forums\Discussion');
    }
}
