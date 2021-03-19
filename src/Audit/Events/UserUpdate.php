<?php

namespace AndrykVP\Rancor\Audit\Events;

use Illuminate\Http\Request;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Auth;

class UserUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Class Variable User
     * 
     * @var App\Models\User
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
