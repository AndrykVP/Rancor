<?php

namespace AndrykVP\Rancor\Forums;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'title', 'description', 'slug', 'category_id', 'parent_id', 'order' ];

    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'forum_boards';

    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $hidden = ['pivot'];

    /**
     * Relationship to Group model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->morphToMany('AndrykVP\Rancor\Forums\Group','groupable','forum_groupables')->withTimestamps();
    }

    /**
     * Relationship to Discussion model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function category()
    {
        return $this->belongsTo('AndrykVP\Rancor\Forums\Category');
    }

    /**
     * Inverse Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('AndrykVP\Rancor\Forums\Board');
    }

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('AndrykVP\Rancor\Forums\Board','parent_id');
    }

    /**
     * Relationship to Discussion model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussions()
    {
        return $this->hasMany('AndrykVP\Rancor\Forums\Discussion');
    }

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function moderators()
    {
        return $this->belongsToMany('App\User', 'forum_board_user')->withTimestamps();
    }

    /**
     * Relationship to Reply model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasManyThrough('AndrykVP\Rancor\Forums\Reply','AndrykVP\Rancor\Forums\Discussion');
    }

    /**
     * Retrieve latest row of Reply model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latest_reply()
    {
        return $this->hasOneThrough('AndrykVP\Rancor\Forums\Reply','AndrykVP\Rancor\Forums\Discussion')->with(['author','discussion'])->latest();
    }

    /**
     * Scope a query to only include boards that do not have parents.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTopTier($query)
    {
        return $query->where('parent_id', null);
    }
}
