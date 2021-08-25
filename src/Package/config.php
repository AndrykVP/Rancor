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
        // otherwise, ['auth'] is enough, unless you have a custom middleware.
        // Additionally, Rancor allows you to restrict user-side pages to Users
        // that are not marked as banned. Uncomment 'unbanned' to enable this.

        'web' => [
            'auth',
            // 'unbanned',
        ],


        // For User models that use an api_token column, use 'auth:api'
        // For Laravel/Sanctum, use 'auth:sanctum'. Otherwise if you use
        // a custom middleware, use its alias here

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
    | This pagination is used in all views that require pagination, for example
    | the Admin panel, as well as the forum Discussions
    |
    */

    'pagination' => 10,


    /*
    |--------------------------------------------------------------------------
    | Scanner
    |--------------------------------------------------------------------------
    |
    | Configuration used in the scanner module
    |
    */

    'scanner' => [

        // The id of the quadrant containing the home system of your
        // faction. You can find this in the database, or you can contact
        // the dev team of the Rancor package for help
        'index' => 24
    ],
];
