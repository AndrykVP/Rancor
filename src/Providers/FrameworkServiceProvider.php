<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class FrameworkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Merge Configuration for access in Package Helpers
        $this->mergeConfigFrom(
            __DIR__.'/../../config/app.php', 'rancor'
        );

        // Publishes config files
        $this->publishes([
            __DIR__.'/../../database/seeds' => database_path('seeds'),
        ],'seeds');

        // Register all the Package's Service Providers
        $this->app->register(EventServiceProvider::class);  
        $this->app->register(AuditServiceProvider::class);  
        $this->app->register(AuthServiceProvider::class);  
        $this->app->register(StructureServiceProvider::class); 
        $this->app->register(ForumsServiceProvider::class); 
        $this->app->register(NewsServiceProvider::class); 
        
        // Add log channel to stack
        $this->app->make('config')->set('logging.channels.rancor', [
            'driver' => 'single',
            'path' => storage_path('logs/rancor.log'),
            'level' => 'debug',
        ]); 
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Register Morph Map
        Relation::morphMap([
            'users' => 'App\User',
            'roles' => 'AndrykVP\Rancor\Auth\Role',
            'categories' => 'AndrykVP\Rancor\Forums\Category',
            'boards' => 'AndrykVP\Rancor\Forums\Board',
        ]);

        // Load views
        $this->loadViewsFrom(__DIR__.'/../Package/Resources/Views','rancor');
        
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../Package/Routes/web.php');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // Load factories
        $this->loadFactoriesFrom(__DIR__.'/../../database/factories');

        // Publishes config files
        $this->publishes([
            __DIR__.'/../../config/app.php' => config_path('rancor.php'),
        ],'config');
    }
}
