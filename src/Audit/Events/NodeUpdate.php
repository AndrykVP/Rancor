<?php

namespace AndrykVP\Rancor\Audit\Events;

use Illuminate\Http\Request;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use AndrykVP\Rancor\Holocron\Models\Node;

class NodeUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Class Variable User
     * 
     * @var \AndrykVP\Rancor\Holocron\Models\Node
     */
    public $node;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Node $node)
    {
        $this->node = $node;
    }
}
