<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SWC Web Services Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for communicating with the Star
    | Wars Combine web services. If you haven't already, you must register
    | your app here: https://www.swcombine.com/ws/registration/ and use the
    | information provided there, to configure this service.
    |
    */

    'response_type' => env('SWC_API_RESPONSE', 'code'),

    'client' => [
       'id' => env('SWC_API_CLIENTID', null),
       'secret' => env('SWC_API_CLIENTSECRET', null),
       'interface' => env('SWC_API_CLIENTINTERFACE', '/oauth'),
    ],

    'access_type' => env('SWC_API_ACCESS', 'online'),

];
