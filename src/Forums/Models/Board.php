<?php

namespace AndrykVP\Rancor\Forums\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use AndrykVP\Rancor\Database\Factories\BoardFactory;

class Board extends Model
{
    use HasFactory;
    
    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'name', 'description', 'slug', 'category_id', 'parent_id', 'lineup' ];

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
        return $this->morphToMany(Group::class,'groupable','forum_groupables')->withTimestamps();
    }

    /**
     * Relationship to Discussion model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Inverse Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Board::class,'parent_id');
    }

    /**
     * Relationship to Discussion model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function moderators()
    {
        return $this->belongsToMany(User::class, 'forum_board_user')->withTimestamps();
    }

    /**
     * Relationship to Reply model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasManyThrough(Reply::class, Discussion::class);
    }

    /**
     * Retrieve latest row of Reply model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latest_reply()
    {
        return $this->hasOneThrough(Reply::class, Discussion::class)->with(['author','discussion'])->latest();
    }

    /**
     * Retrieve the last page of the associated Replies
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function last_page()
    {
        return ceil($this->replies->count()/config('rancor.pagination'));
    }

    /**
     * Scope a query to only include boards that do not have parents.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTopTier($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return BoardFactory::new();
    }
}
