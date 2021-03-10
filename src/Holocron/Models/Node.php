<?php

namespace AndrykVP\Rancor\Holocron\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Auth;
use App\Models\User;
use AndrykVP\Rancor\Audit\Events\NodeUpdate;
use AndrykVP\Rancor\Database\Factories\NodeFactory;
use AndrykVP\Rancor\Holocron\Models\Collection;

class Node extends Model
{
    use HasFactory;
    
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return NodeFactory::new();
    }
    
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'holocron_nodes';

    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'name', 'body', 'is_public', 'author_id', 'editor_id' ];

    /**
     * Attributes casted to native types
     * 
     * @var array
     */
    protected $casts = [
        'is_published' => 'boolean',
        'is_private' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $hidden = ['pivot'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'updating' => NodeUpdate::class,
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('access', function (Builder $builder) {
            if(Auth::check() && Auth::user()->can('viewAny', Node::class))
            {
                $builder;
            }
            else
            {
                $builder->where('is_public', true);
            }
        });
    }

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    /**
     * Relationship to Collection model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'holocron_collection_node')->withTimestamps();
    }
}
