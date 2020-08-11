<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\ServiceProvider;

class AuditServiceProvider extends ServiceProvider
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
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../Audit/Routes/api.php');

        // Publish Http Files
        $this->publishes([
            __DIR__.'/../Audit/Http/Controllers' => app_path('Http/Controllers/Rancor/Audit'),
        ], 'http');
    }
}
