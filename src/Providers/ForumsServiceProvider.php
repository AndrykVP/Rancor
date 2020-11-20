<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use AndrykVP\Rancor\Faction\Faction;

class ForumsServiceProvider extends ServiceProvider
{
    /**
     * Custom Package policies
     * 
     * @var array
     */
    protected $policies = [
       //
    ];

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
        //$this->loadRoutesFrom(__DIR__.'/../Forums/Routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../Forums/Routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../Forums/Resources/Views','rancor.forums');
        
        // Register policies
        $this->registerPolicies();

        // Publish Assets
        $this->publishes([
            __DIR__.'/../Forums/Http/Controllers' => app_path('Http/Controllers/Rancor/Forums'),
            __DIR__.'/../Forums/Http/Requests' => app_path('Http/Requests/Rancor/Forums'),
            __DIR__.'/../Forums/Http/Resources' => app_path('Http/Resources/Rancor/Forums'),
        ], 'http');        
        $this->publishes([
            __DIR__.'/../Forums/Resources/Views' => resource_path('views/andrykvp/rancor'),
        ], 'views');        
    }

    /**
     * Method to register custom policies
     * 
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }
}