<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;

class FrameworkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register all the Package's Service Providers
        $this->app->register(
            APIServiceProvider::class,
            AuthServiceProvider::class,
            FactionServiceProvider::class,
            IDGenServiceProvider::class,
        );  
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Load routes and migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        
        // Add log channel to stack
        $this->app->make('config')->set('logging.channels.swc', [
            'driver' => 'single',
            'path' => storage_path('logs/swc.log'),
            'level' => 'debug',
        ]);
    }
}
