<?php

namespace AndrykVP\Rancor\Forums;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'title', 'category_id', 'author_id' ];

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
}
