<?php

namespace AndrykVP\Rancor\Audit;

use Illuminate\Database\Eloquent\Model;

class AwardLog extends Model
{
    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'award_id', 'action'];

    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'changelog_awards';

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }

    /**
     * Relationship to Award model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function award()
    {
        return $this->belongsTo('AndrykVP\Rancor\Structure\Award');
    }
}
