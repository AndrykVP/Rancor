<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Auth Middleware
    |--------------------------------------------------------------------------
    |
    | Here you may specify an array of middlewares to use for route authentication
    | for both web and api routes. If you use custom middlewares, they can be added
    | or replaced here.
    |
    */

    'middleware' => [

        // If you request users to verify email, use ['auth', 'verified']
        // Otherwise, ['auth'] is enough, unless you have a custom middleware

        'web' => ['auth'],


        // For User models that use an api_token column, use 'auth:api'
        // For Laravel/Sanctum, use 'auth:sanctum'

        'api' => ['auth:api'],
    ],


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
    ],


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | Specify how many resources to display per page in the index Views.
    | This pagination is used in the Admin panel, as well as the forum Discussions
    |
    */

    'pagination' => 10,
];
