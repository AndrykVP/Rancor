<?php

namespace AndrykVP\Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use AndrykVP\Rancor\Audit\Contracts\LogContract;
use AndrykVP\Rancor\DB\Factories\AwardLogFactory;
use AndrykVP\Rancor\Structure\Models\Award;

class AwardLog extends Model implements LogContract
{
   use HasFactory;

   protected $table = 'changelog_awards';

   public function user(): BelongsTo
   {
      return $this->belongsTo(User::class);
   }

   public function award(): BelongsTo
   {
      return $this->belongsTo(Award::class);
   }

   public function creator(): BelongsTo
   {
      return $this->belongsTo(User::class, 'updated_by');
   }

   public function message(): string
   {
      return $this->user->name . 'has received the award "' . $this->award->name . '" from ' . $this->creator->name;
   }

   protected static function newFactory(): Factory
   {
      return AwardLogFactory::new();
   }
}
