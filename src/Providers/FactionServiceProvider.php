<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use AndrykVP\Rancor\Faction\Faction;
use AndrykVP\Rancor\Faction\Department;
use AndrykVP\Rancor\Faction\Rank;
use AndrykVP\Rancor\Faction\Policies\FactionPolicy;
use AndrykVP\Rancor\Faction\Policies\DepartmentPolicy;
use AndrykVP\Rancor\Faction\Policies\RankPolicy;

class FactionServiceProvider extends ServiceProvider
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
        $this->loadRoutesFrom(__DIR__.'/../Faction/Routes/api.php');
        
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