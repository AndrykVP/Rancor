<?php

namespace Rancor\Audit\Listeners;

use Rancor\Audit\Events\NodeUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateNodeLog
{
	/**
	 * User model making edits to a node
	 * 
	 * @var App\Models\User
	 */
	protected $user;

	/**
	 * Create the event listener.
	 *
	 * @param  Request  $request
	 * @return void
	 */
	public function __construct(Request $request)
	{
		$this->user = $request->user();
	}

	/**
	 * Handle the event.
	 *
	 * @param  NodeUpdate  $event
	 * @return void
	 */
	public function handle(NodeUpdate $event)
	{
		if($event->node->isDirty('name') || $event->node->isDirty('body'))
		{
			DB::table('changelog_nodes')->insert([
				'node_id' => $event->node->id,
				'updated_by' => $this->user->id,
				'old_name' => $event->node->isDirty('name') ? $event->node->getOriginal('name') : null,
				'old_body' => $event->node->isDirty('body') ? $event->node->getOriginal('body') : null,
				'created_at' => now(),
				'updated_at' => now(),
			]);
		}
	}
}
