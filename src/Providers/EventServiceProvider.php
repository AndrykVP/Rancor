<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use AndrykVP\Rancor\Scanner\Events\EditScan;
use AndrykVP\Rancor\Scanner\Listeners\CreateScanLog;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        EditScan::class => [
            CreateScanLog::class,
        ]
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