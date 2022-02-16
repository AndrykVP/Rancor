<?php

namespace Rancor\Forums\Listeners;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rancor\Forums\Events\VisitDiscussion;

class MarkDiscussionRead
{
	public $user_id;

	/**
	 * Class constructor
	 */
	public function __construct(Request $request)
	{
		$this->user_id = $request->user()->id;
	}

	/**
	 * Handle the event.
	 *
	 * @param  CreateDiscussion  $event
	 * @return void
	 */
	public function handle(VisitDiscussion $event)
	{
		DB::table('forum_unread_discussions')
		->where('discussion_id', $event->discussion->id)
		->where('user_id', $this->user_id)
		->update(['reply_count' => 0]);
	}
}
