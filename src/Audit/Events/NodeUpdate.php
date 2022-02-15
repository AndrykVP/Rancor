<?php

namespace Rancor\Audit\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Rancor\Holocron\Models\Node;

class NodeUpdate
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * Node model to audit
	 * 
	 * @var \Rancor\Holocron\Models\Node
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
