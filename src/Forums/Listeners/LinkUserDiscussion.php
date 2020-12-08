<?php

namespace AndrykVP\Rancor\Forums\Listeners;

use Illuminate\Support\Facades\DB;
use AndrykVP\Rancor\Forums\Events\CreateReply;

class LinkUserDiscussion
{
    public $users;

    /**
     * Class constructor
     */
    public function __construct()
    {
      $this->users = DB::table('users')->pluck('id')->toArray();
    }

    /**
     * Handle the event.
     *
     * @param  CreateDiscussion  $event
     * @return void
     */
    public function handle(CreateReply $event)
    {
      $event->reply->discussion->visitors()->sync($this->users);
    }
}
