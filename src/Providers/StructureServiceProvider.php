<?php

namespace Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Rancor\Structure\Models\Award;
use Rancor\Structure\Models\Faction;
use Rancor\Structure\Models\Department;
use Rancor\Structure\Models\Rank;
use Rancor\Structure\Models\AwardType;
use Rancor\Structure\Policies\AwardPolicy;
use Rancor\Structure\Policies\FactionPolicy;
use Rancor\Structure\Policies\DepartmentPolicy;
use Rancor\Structure\Policies\RankPolicy;
use Rancor\Structure\Policies\AwardTypePolicy;

class StructureServiceProvider extends ServiceProvider
{
    /**
     * Custom Package policies
     * 
     * @var array
     */
    protected $policies = [
        Award::class => AwardPolicy::class,
        Faction::class => FactionPolicy::class,
        Department::class => DepartmentPolicy::class,
        Rank::class => RankPolicy::class,
        AwardType::class => AwardTypePolicy::class,
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

        // Publish Views
        $this->publishes([
            __DIR__.'/../Structure/Resources/Views' => resource_path('views/vendor/rancor')
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