<?php

namespace AndrykVP\SWC\Providers;

use Illuminate\Support\ServiceProvider;
use AndrykVP\SWC\Commands\SyncDatabase;

class SWCServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
      $this->publishes([
        __DIR__.'/../config/APIconfig.php' => config_path('swc.php'),
        __DIR__.'/../config/IDGenconfig.php' => config_path('idgen.php'),
    ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
      $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

      if (! class_exists('CreateSectorsTable')) {
         $this->publishes([
           __DIR__ . '/../Migrations/create_sectors_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_sectors_table.php'),
         ], 'migrations');
      }
      if (! class_exists('CreateSystemsTable')) {
         $this->publishes([
           __DIR__ . '/../Migrations/create_systems_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_systems_table.php'),
         ], 'migrations');
      }
      if (! class_exists('CreatePlanetsTable')) {
         $this->publishes([
           __DIR__ . '/../Migrations/create_planets_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_planets_table.php'),
         ], 'migrations');
      }


      if ($this->app->runningInConsole()) {
        $this->commands([
            SyncDatabase::class,
        ]);
      }
    }
}
