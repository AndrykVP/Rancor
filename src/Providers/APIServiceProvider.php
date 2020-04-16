<?php

namespace AndrykVP\SWC\API;

use Illuminate\Support\ServiceProvider;

class APIServiceProvider extends ServiceProvider
{
    /**
     * Construct the Service
     */
    private $paths, $client, $response_type, $access_type;

    public function __construct()
    {
        $this->paths = [
            'auth' => 'https://www.swcombine.com/ws/oauth2/auth/',
            'request' => 'https://www.swcombine.com/ws/v1.0/',
            'revoke' => 'https://www.swcombine.com/ws/oauth2/revoke/',
            'token' => 'https://www.swcombine.com/ws/oauth2/token/',
        ];
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->publishes([
            __DIR__.'/config.php' => config_path('swc.php'),
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
