<?php

namespace CasWaryn\IDGen;

use Illuminate\Support\ServiceProvider;

class IDGenServiceProvider extends ServiceProvider
{
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
        $this->publishes([
            __DIR__.'/config.php' => config_path('idgen.php'),
        ]);
    }
}
