<?php

namespace AndrykVP\Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use AndrykVP\Rancor\Audit\Contracts\LogContract;
use AndrykVP\Rancor\DB\Factories\EntryLogFactory;
use AndrykVP\Rancor\Scanner\Enums\Alliance;
use AndrykVP\Rancor\Scanner\Models\Entry;

class EntryLog extends Model implements LogContract
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'updated_by', 'entry_id', 'old_type', 'old_name', 'old_owner', 'old_teritory_id', 'old_alliance',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'old_alliance' => Alliance::class,
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'changelog_entries';

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
     * Relationship to Entry model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }

    /**
     * Method to render Log message in views
     * 
     * @return string
     */
    public function message()
    {
        return 'Entry #' . $this->entry->entity_id . ' has been modified by ' . $this->creator->name;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return EntryLogFactory::new();
    }
}
