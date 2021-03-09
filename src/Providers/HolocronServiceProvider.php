<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use AndrykVP\Rancor\Holocron\Models\Collection;
use AndrykVP\Rancor\Holocron\Models\Node;
use AndrykVP\Rancor\Holocron\Policies\CollectionPolicy;
use AndrykVP\Rancor\Holocron\Policies\NodePolicy;

class HolocronServiceProvider extends ServiceProvider
{
    /**
     * Custom Package policies
     * 
     * @var array
     */
    protected $policies = [
       Node::class => NodePolicy::class,
       Collection::class => CollectionPolicy::class,
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
        $this->loadRoutesFrom(__DIR__.'/../Holocron/Routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../Holocron/Routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../Holocron/Resources/Views', 'rancor');
        
        // Register policies
        $this->registerPolicies();

        // Publish Assets   
        $this->publishes([
            __DIR__.'/../Holocron/Resources/Views' => resource_path('views/rancor'),
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