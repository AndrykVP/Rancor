<?php

namespace AndrykVP\Rancor\Scanner\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EditScan
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $old_entry;
    public $new_entry;
    public $user_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($old, $new, $uid)
    {
        $this->old_entry = $old;
        $this->new_entry = $new;
        $this->user_id = $uid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('scanner');
    }
}
