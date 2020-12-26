<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Web Auth middleware
    |--------------------------------------------------------------------------
    |
    | Here you may specify the middleware to use for HTTP route authentication
    | If you request users to verify email, use ['auth', 'verified']
    | Otherwise, 'auth' is enough, unless you have a custom middleware
    |
    */

    'middleware.web' => 'auth',

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

    'middleware.api' => 'auth:api',


    /*
    |--------------------------------------------------------------------------
    | Date Format
    |--------------------------------------------------------------------------
    |
    | Here you may specify the PHP datetime format to use when retrieving
    | dates on resources.
    |
    */

    'dateFormat' => 'M j, Y, G:i e',


    /*
    |--------------------------------------------------------------------------
    | Audit User Log Colors
    |--------------------------------------------------------------------------
    |
    | Here you may specify the colors you want to use for the Rank Change
    | user logs. This is particularly useful with CSS Frameworks like
    | Bootstrap, Bulma and Tailwind that use color names in their syntax
    | or simply use hexadecimal codes.
    |
    */

    'audit' => [
        'info' => 'blue',
        'warning' => 'yellow',
        'alert' => 'red',
    ]
];
