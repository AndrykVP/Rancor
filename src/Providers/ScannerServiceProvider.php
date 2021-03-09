<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use AndrykVP\Rancor\Scanner\Models\Entry;
use AndrykVP\Rancor\Scanner\Models\Log;
use AndrykVP\Rancor\Scanner\Policies\EntryPolicy;
use AndrykVP\Rancor\Scanner\Policies\LogPolicy;

class ScannerServiceProvider extends ServiceProvider
{
    /**
     * Custom Package policies
     * 
     * @var array
     */
    protected $policies = [
        Entry::class => EntryPolicy::class,
        Log::class => LogPolicy::class,
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