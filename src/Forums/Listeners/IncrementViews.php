<?php

namespace AndrykVP\Rancor\Forums\Listeners;

use Illuminate\Http\Request;
use AndrykVP\Rancor\Forums\Events\VisitDiscussion;

class IncrementViews
{
    public $visited_discussions;

    /**
     * Class constructor
     */
    public function __construct(Request $request)
    {
        $this->visited_discussions = $request->session()->get('visited_discussions', array());
    }

    /**
     * Handle the event.
     *
     * @param  VisitDiscussion  $event
     * @return void
     */
    public function handle(VisitDiscussion $event)
    {
        if(!in_array($event->discussion->id,$this->visited_discussions))
        {
            $event->discussion->increment('views');
        }
    }
}
