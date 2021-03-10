<?php

namespace AndrykVP\Rancor\Forums\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use AndrykVP\Rancor\Database\Factories\DiscussionFactory;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Models\Reply;

class Discussion extends Model
{
    use HasFactory;
    
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
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function visitors()
    {
        return $this->belongsToMany(User::class, 'forum_discussion_user')->withTimestamps();
    }

    /**
     * Relationship to Categories model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Relationship to Replies model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Retrieve latest row of Reply model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latest_reply()
    {
        return $this->hasOne(Reply::class)->with('author')->latest();
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
