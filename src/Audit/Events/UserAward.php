<?php

namespace AndrykVP\Rancor\Audit\Events;

use Illuminate\Http\Request;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use AndrykVP\Rancor\Structure\Models\Award;

class UserAward
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Class Variables
     * 
     * @var \AndrykVP\Rancor\Structure\Award
     * @var int  $change
     */
    public $award;
    public $action;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Award $award)
    {
        $this->award = $award;
    }
}
