<?php

namespace AndrykVP\Rancor\Forums\Events;

use Illuminate\Http\Request;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use AndrykVP\Rancor\Forums\Reply;

class CreateReply
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Class Variable Reply
     * 
     * @var AndrykVP\Rancor\Forums\Reply
     */
    public $reply;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }
}
