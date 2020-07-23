<?php

namespace AndrykVP\Rancor\Scanner;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'entry_id', 'old_type', 'new_type', 'old_name', 'new_name', 'old_owner', 'new_owner', 'old_position', 'new_position'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'old_position' => 'array',
        'new_position' => 'array',
    ];

    /**
     * The attributes that should be cast to date format.
     *
     * @var array
     */
    protected $dates = [
        'previously_seen', 'last_seen'
    ];

    /**
     * The primary keys of the table are not auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Deactivating timestamp tables.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scanner_logs';

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contributor()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Relationship to Entry model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entry()
    {
        return $this->belongsTo('AndrykVP\Rancor\Scanner\Entry');
    }
}
