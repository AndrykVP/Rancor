<?php

namespace AndrykVP\Rancor\Audit\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use AndrykVP\Rancor\Structure\Models\Award;

class UserAwards
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Class Variables
     * 
     * @var \App\Models\User
     * @var \AndrykVP\Rancor\Structure\Models\Award
     * @var integer
     */
    public $user;
    public $awards;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Array $awards)
    {
        $this->user = $user->load('awards');
        $this->awards = $awards;
    }
}
