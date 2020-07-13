<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Auth middleware
    |--------------------------------------------------------------------------
    |
    | Here you may specify the middleware to use for route authentication
    | For User models that use an api_token column, use 'auth:api'
    | For Laravel/Sanctum, use 'auth:sanctum'
    | Or if you register a custom middleware, specify the guard here
    |
    */

    'middleware' => 'auth:api',
];
