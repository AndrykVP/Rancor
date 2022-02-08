<?php

namespace AndrykVP\Rancor\Audit\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use AndrykVP\Rancor\Scanner\Models\Entry;

class EntryUpdate
{
   use Dispatchable, InteractsWithSockets, SerializesModels;

   public $entry;

   public function __construct(Entry $entry)
   {
      $this->entry = $entry;
   }
}
