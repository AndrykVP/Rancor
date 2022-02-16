<?php

namespace Rancor\Forums\Events;

use Illuminate\Http\Request;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Rancor\Forums\Models\Discussion;

class VisitDiscussion
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * Class Variable Discussion
	 * 
	 * @var Rancor\Forums\Models\Discussion
	 */
	public $discussion;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(Discussion $discussion)
	{
		$this->discussion = $discussion;
	}
}
