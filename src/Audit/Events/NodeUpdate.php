<?php

namespace AndrykVP\Rancor\Audit\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use AndrykVP\Rancor\Holocron\Models\Node;

class NodeUpdate
{
   use Dispatchable, InteractsWithSockets, SerializesModels;

   public $node;

   public function __construct(Node $node)
   {
      $this->node = $node;
   }
}
