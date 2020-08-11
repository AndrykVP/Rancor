<?php

namespace AndrykVP\Rancor\Audit\Events;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RankChange
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Class Variable User
     * 
     * @var App\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
