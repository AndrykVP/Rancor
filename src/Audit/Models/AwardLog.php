<?php

namespace AndrykVP\Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use AndrykVP\Rancor\Audit\Contracts\LogContract;
use AndrykVP\Rancor\Structure\Models\Award;

class AwardLog extends Model implements LogContract
{
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
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to Award model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function award()
    {
        return $this->belongsTo(Award::class);
    }

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Method to render Log message in views
     * 
     * @return string
     */
    public function message()
    {
        return $this->user->name . 'has received the award "' . $this->award->name . '" from ' . $this->creator->name;
    }
}
