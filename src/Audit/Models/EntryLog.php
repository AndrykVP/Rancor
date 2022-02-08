<?php

namespace AndrykVP\Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use AndrykVP\Rancor\Audit\Contracts\LogContract;
use AndrykVP\Rancor\DB\Factories\EntryLogFactory;
use AndrykVP\Rancor\Scanner\Enums\Alliance;
use AndrykVP\Rancor\Scanner\Models\Entry;

class EntryLog extends Model implements LogContract
{
   use HasFactory;

   protected $table = 'changelog_entries';

   protected $fillable = [
      'updated_by',
      'entry_id',
      'old_type',
      'old_name',
      'old_owner',
      'old_teritory_id',
      'old_alliance',
   ];
   
   protected $casts = [
      'old_alliance' => Alliance::class,
   ];
   
   public function creator(): BelongsTo
   {
      return $this->belongsTo(User::class, 'updated_by');
   }

   public function entry(): BelongsTo
   {
      return $this->belongsTo(Entry::class);
   }

   public function message(): string
   {
      return 'Entry #' . $this->entry->entity_id . ' has been modified by ' . $this->creator->name;
   }

   protected static function newFactory(): Factory
   {
      return EntryLogFactory::new();
   }
}
