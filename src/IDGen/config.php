<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Template Folders
    |--------------------------------------------------------------------------
    |
    | Here you may specify the template folders to use for rendering
    | Signatures and Avatars.
    |
    */

    'templates' => [

        'default' => [
            'input' => 'default',
            'output' => 'ids',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Avatar Settings
    |--------------------------------------------------------------------------
    |
    | Here you may specify the naming convention of the template images
    | that will be used in rendering Avatars as well as the dimensions
    | for each size. By default: large are 150x150 and small are 100x100.
    | You may also choose a sufix to append to the generated images.
    |
    */

    'avatar' => [

        'large' => [
            'background' => 'avatar_lg_bg',
            'frame' => 'avatar_lg_frame',
            'mask' => 'avatar_lg_mask',
            'dimensions' => '150',
            'handle' => [
                'display' => true,
                'position' => '33,132',
                'size' => 6,
                'rotation' => 0,
            ],
            'rank' => [
                'display' => true,
                'position' => '63,132',
                'size' => 4,
                'rotation' => 0,
            ]
        ],

        'small' => [
            'background' => 'avatar_sm_bg',
            'frame' => 'avatar_sm_frame',
            'mask' => 'avatar_sm_mask',
            'dimensions' => '100',
            'handle' => [
                'display' => true,
                'position' => '33,132',
                'size' => 4,
                'rotation' => 0,
            ]
        ],

        'suffix' => '_avatar'
    ],

    /*
    |--------------------------------------------------------------------------
    | Signature Settings
    |--------------------------------------------------------------------------
    |
    | Here you may specify the naming convention of the template images
    | that will be used in rendering Signaturess as well as the dimensions
    | and sufix to append to the generated images.
    |
    */

    'signature' => [

        'background' => 'signature_bg',
        'frame' => 'signature_frame',
        'mask' => 'signature_mask',
        'logo' => 'signature_logo',
        'dimensions' => '530x170',
        'suffix' => '_signature'

    ],


    /*
    |--------------------------------------------------------------------------
    | Colors
    |--------------------------------------------------------------------------
    |
    | Here you may specify the hexadecimal code for the colors you wish
    | to use in the creation of Avatars and Signatures.
    |
    */

    'colors' => [

        'primary' => '#FFF',        // Used in names and attribute values
        'accent' => '#3F67G3',      // Used in badges
        'muted' => '#CCC',          // Used in titles and legends
    ],

    
    /*
    |--------------------------------------------------------------------------
    | Fonts
    |--------------------------------------------------------------------------
    |
    | Here you may specify the location of your custom fonts. Where sans
    | is used for the User Name, and serif is used for the user fields
    | such as Rank, Department, Email, etc.
    |
    */

    'fonts' => [
        'sans' => public_path('fonts/sans.ttf'),
        'serif' => public_path('fonts/serif.ttf')
    ],
];
