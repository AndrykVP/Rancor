<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use AndrykVP\Rancor\Structure\Faction;
use AndrykVP\Rancor\Structure\Department;
use AndrykVP\Rancor\Structure\Rank;
use AndrykVP\Rancor\Structure\Policies\FactionPolicy;
use AndrykVP\Rancor\Structure\Policies\DepartmentPolicy;
use AndrykVP\Rancor\Structure\Policies\RankPolicy;

class StructureServiceProvider extends ServiceProvider
{
    /**
     * Custom Package policies
     * 
     * @var array
     */
    protected $policies = [
        Faction::class => FactionPolicy::class,
        Department::class => DepartmentPolicy::class,
        Rank::class => RankPolicy::class,
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
        $this->loadRoutesFrom(__DIR__.'/../Structure/Routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../Structure/Routes/web.php');
        
        // Load views
        $this->loadViewsFrom(__DIR__.'/../Structure/Resources/Views','rancor');

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

        Gate::define('manage-faction', function ($user) {
            return $user->hasPermission('manage-faction');
        });
    }
}