<?php

namespace Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Rancor\Scanner\Models\Entry;
use Rancor\Scanner\Models\Quadrant;
use Rancor\Scanner\Models\Territory;
use Rancor\Scanner\Models\TerritoryType;
use Rancor\Scanner\Policies\EntryPolicy;
use Rancor\Scanner\Policies\QuadrantPolicy;
use Rancor\Scanner\Policies\TerritoryPolicy;
use Rancor\Scanner\Policies\TerritoryTypePolicy;

class ScannerServiceProvider extends ServiceProvider
{
    /**
     * Custom Package policies
     * 
     * @var array
     */
    protected $policies = [
        Entry::class => EntryPolicy::class,
        Quadrant::class => QuadrantPolicy::class,
        Territory::class => TerritoryPolicy::class,
        TerritoryType::class => TerritoryTypePolicy::class,
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
        $this->loadRoutesFrom(__DIR__.'/../Scanner/Routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../Scanner/Routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../Scanner/Resources/Views', 'rancor');

        // Publish Views
        $this->publishes([
            __DIR__.'/../Scanner/Resources/Views' => resource_path('views/vendor/rancor')
        ], 'rancor-views');
        
        // Register policies
        $this->registerPolicies();
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