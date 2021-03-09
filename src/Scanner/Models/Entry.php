<?php

namespace AndrykVP\Rancor\Scanner\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AndrykVP\Rancor\Database\Factories\EntryFactory;
use AndrykVP\Rancor\Scanner\Events\EditScan;
use AndrykVP\Rancor\Scanner\Models\Log;
use App\Models\User;

class Entry extends Model
{
    use HasFactory;
    
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return EntryFactory::new();
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'name', 'owner', 'position', 'last_seen'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_by'
    ];

    /**
     * The attributes that should be cast to date format.
     *
     * @var array
     */
    protected $dates = [
        'last_seen'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'position' => 'array',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scanner_entries';

    /**
     * Registers custom events for the model.
     * 
     * @var array
     */
    protected $dispatchesEvents = [
        'updating' => EditScan::class,
    ];

    /**
     * Relationship to Log model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function changelog()
    {
        return $this->hasMany(Log::class)->latest();
    }

    /**
     * Relationship to User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contributor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
