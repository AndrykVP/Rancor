<?php

namespace AndrykVP\Rancor\Forums\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use AndrykVP\Rancor\Forums\Events\CreateReply;
use AndrykVP\Rancor\Database\Factories\ReplyFactory;
use AndrykVP\Rancor\Forums\Models\Discussion;

class Reply extends Model
{
    use HasFactory;
    
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ReplyFactory::new();
    }
    
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
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editor()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to Discussion model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
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
