<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use AndrykVP\Rancor\API\Console\Commands\SyncDatabase;

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
