<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use AndrykVP\Rancor\Auth\Listeners\UserLastLogin;
use AndrykVP\Rancor\Audit\Events\RankChange;
use AndrykVP\Rancor\Audit\Listeners\UserLoginIP;
use AndrykVP\Rancor\Audit\Listeners\UserRegisteredIP;
use AndrykVP\Rancor\Audit\Listeners\UserRank;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        Registered::class => [
            UserRegisteredIP::class,
        ],
        Login::class => [
            UserLoginIP::class,
            UserLastLogin::class,
        ],
        RankChange::class => [
            UserRank::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}