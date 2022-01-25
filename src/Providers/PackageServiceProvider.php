<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;

class PackageServiceProvider extends ServiceProvider
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
            __DIR__.'/../Package/config.php', 'rancor'
        );

        // Register all the Package's Service Providers
        $this->app->register(EventServiceProvider::class);  
        $this->app->register(APIServiceProvider::class);  
        $this->app->register(AuditServiceProvider::class);  
        $this->app->register(AuthServiceProvider::class);  
        $this->app->register(StructureServiceProvider::class); 
        $this->app->register(ForumsServiceProvider::class); 
        $this->app->register(NewsServiceProvider::class); 
        $this->app->register(ScannerServiceProvider::class);  
        $this->app->register(HolocronServiceProvider::class);  
        
        // Add log channel to stack
        $this->app->make('config')->set('logging.channels.rancor', [
            'driver' => 'single',
            'path' => storage_path('logs/rancor.log'),
            'level' => 'debug',
        ]); 
        
        // Add storage disk to stack
        $this->app->make('config')->set('filesystems.disks.idgen', [
            'driver' => 'local',
            'root' => storage_path('idgen'),
            'visibility' => 'private',
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
            'users' => 'App\Models\User',
            'roles' => 'AndrykVP\Rancor\Auth\Models\Role',
            'categories' => 'AndrykVP\Rancor\Forums\Models\Category',
            'boards' => 'AndrykVP\Rancor\Forums\Models\Board',
        ]);

        // Load views
        $this->loadViewsFrom(__DIR__.'/../Package/Resources/Views','rancor');
        Blade::componentNamespace('AndrykVP\\Rancor\\Package\\View\\Components', 'rancor');

        // Publish Views
        $this->publishes([
            __DIR__.'/../Package/Resources/Views' => resource_path('views/vendor/rancor')
        ], 'rancor-views');
        
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../Package/Routes/web.php');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // Publishes config files
        $this->publishes([
            __DIR__.'/../../config/app.php' => config_path('rancor.php'),
        ],'rancor-config');
    }
}
