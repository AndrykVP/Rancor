<?php

namespace AndrykVP\Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use AndrykVP\Rancor\Audit\Contracts\LogContract;
use AndrykVP\Rancor\DB\Factories\NodeLogFactory;
use AndrykVP\Rancor\Holocron\Models\Node;

class NodeLog extends Model implements LogContract
{
   use HasFactory;

   protected $table = 'changelog_nodes';

   public function creator(): BelongsTo
   {
      return $this->belongsTo(User::class, 'updated_by');
   }

   public function node(): BelongsTo
   {
      return $this->belongsTo(Node::class)->withoutGlobalScope('access');
   }

   public function message(): string
   {
      return 'Node "' . $this->node->name . '" has been modified by ' . $this->creator->name;
   }

   protected static function newFactory(): Factory
   {
      return NodeLogFactory::new();
   }
}
