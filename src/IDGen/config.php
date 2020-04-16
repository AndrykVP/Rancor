<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Configuration for ID Generator
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for the ID Generator, such as the
    | location of the templates for avatar and signature, as well as their
    | font, and text color.
    |
    */

    // Avatar Configuration
    'avatar' => [
        'templates' => [
            'main' => [
                'large' => [
                    'background' => storage_path('app/id_templates/avatar150_background.png'),
                    'frame' => storage_path('app/id_templates/avatar150_frame.png'),
                    'mask' => storage_path('app/id_templates/avatar150_mask.png'),
                ],
                'small' => [
                    'background' => storage_path('app/id_templates/avatar100_background.png'),
                    'frame' => storage_path('app/id_templates/avatar100_frame.png'),
                    'mask' => storage_path('app/id_templates/avatar100_mask.png'),
                ],
            ]
        ],
        'fonts' => [
            'sans' => public_path('fonts/sans.ttf'),
            'serif' => public_path('fonts/serif.ttf')
        ],
        'colors' => [
            'light' => '#ffffff',
            'dark' => '#000000'
        ]

    ],

    // Signature Configuration
    'signature' => [
        'templates' => [
            'main' => [
                'background' => storage_path('app/id_templates/signature_background.png'),
                'frame' => storage_path('app/id_templates/signature_frame.png'),
                'mask' => storage_path('app/id_templates/signature_mask.png'),
                'logo' => storage_path('app/id_templates/signature_logo.png'),
            ]
        ],
        'dimensions' => [
            'height' => 150,
            'width' => 150
        ],
        'fonts' => [
            'sans' => public_path('fonts/sans.ttf'),
            'serif' => public_path('fonts/serif.ttf')
        ],
        'colors' => [
            'light' => '#ffffff',
            'dark' => '#000000'
        ]

    ],

    // General Settings
    'output_folder' => storage_path('app/public/ids'),
    'uppercase' => true,

];
