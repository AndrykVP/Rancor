<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use AndrykVP\Rancor\API\Commands\SyncDatabase;
use AndrykVP\Rancor\API\Commands\SyncGalaxy;

class APIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Bind API Console Commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                SyncDatabase::class
            ]);
        }
    }
}
