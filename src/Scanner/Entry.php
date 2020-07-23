<?php

namespace AndrykVP\Rancor\Scanner;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
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
     * The primary keys of the table are not auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scanner_entries';

    /**
     * Relationship to Log model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function changelog()
    {
        return $this->hasMany('AndrykVP\Rancor\Scanner\Log');
    }

    /**
     * Relationship to User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contributor()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }
}
