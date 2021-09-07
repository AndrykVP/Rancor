<?php

namespace AndrykVP\Rancor\Audit\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use AndrykVP\Rancor\Scanner\Models\Entry;

class EntryUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $entry;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
    }
}
