<?php

namespace AndrykVP\Rancor\Forums;

use Illuminate\Database\Eloquent\Model;
use AndrykVP\Rancor\Forums\Events\CreateReply;

class Reply extends Model
{
    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'body', 'discussion_id', 'author_id', 'editor_id' ];

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
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['discussion'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CreateReply::class,
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
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editor()
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

    /**
     * Function to calculate the page within the Discussion view
     * 
     * @return int
     */
    public function getPageAttribute()
    {
        $replies = $this->discussion->replies->pluck('id');
        $index = $replies->search($this->id) + 1;

        $page = ceil($index / config('rancor.pagination'));
        $self = $index % config('rancor.pagination');
        if($self == 0)
        {
           $self = config('rancor.pagination');
        }
        
        return (object)['number' => intval($page), 'index' => intval($self)];
    }
}
