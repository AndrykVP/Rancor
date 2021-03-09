<?php

namespace AndrykVP\Rancor\Forums\Models;

use Illuminate\Database\Eloquent\Model;
use AndrykVP\Rancor\Database\Factories\DiscussionFactory;

class Discussion extends Model
{
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return DiscussionFactory::new();
    }
    
    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'name', 'is_sticky', 'is_locked', 'board_id', 'author_id' ];

    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'forum_discussions';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_sticky' => 'boolean',
        'is_locked' => 'boolean',
    ];

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitors()
    {
        return $this->belongsToMany('App\Models\User', 'forum_discussion_user')->withTimestamps();
    }

    /**
     * Relationship to Categories model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function board()
    {
        return $this->belongsTo('AndrykVP\Rancor\Forums\Board');
    }

    /**
     * Relationship to Replies model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany('AndrykVP\Rancor\Forums\Reply');
    }

    /**
     * Retrieve latest row of Reply model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latest_reply()
    {
        return $this->hasOne('AndrykVP\Rancor\Forums\Reply')->with('author')->latest();
    }

    /**
     * Returns the number of pages in Reply relationship
     * 
     * @return int
     */
    public function getPagesAttribute()
    {
        return ceil($this->replies->count() / config('rancor.pagination'));
    }

    /**
     * Scope a query to include discussions by their is_sticky status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSticky($query, $value = true)
    {
        return $query->where('is_sticky', $value);
    }
}
