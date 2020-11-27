<?php

namespace AndrykVP\Rancor\Forums\Listeners;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use AndrykVP\Rancor\Forums\Events\VisitDiscussion;

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
      $event->discussion->visitors()->detach($this->user_id);
    }
}
