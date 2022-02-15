<?php

namespace Rancor\Audit\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Rancor\Scanner\Models\Entry;

class EntryUpdate
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * Entry model to audit
	 * 
	 * @var \Rancor\Scanner\Models\Entry
	 */
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
