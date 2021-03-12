<?php

namespace AndrykVP\Rancor\Audit\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use AndrykVP\Rancor\Audit\Models\IPLog as Log;

class UserLoginIP
{
    /**
     * Class variables
     * 
     * @var Request $request
     */
    protected $request;

    /**
     * Create the event listener.
     *
     * @param  Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user_id = $event->user->id;
        $ip = $this->request->ip();
        $ua = $this->request->header('User-Agent');

        $log = Log::where([
                    ['user_id', $user_id],
                    ['ip_address', $ip],
                    ['type', 'login']
                ])->first();

        if($log != null)
        {
            $log->update([
                'user_agent' => $ua,
            ]);
        }
        else
        {
            Log::create([
                'user_id' => $user_id,
                'ip_address' => $ip,
                'user_agent' => $ua,
                'type' => 'login',
            ]);
        }
    }
}
