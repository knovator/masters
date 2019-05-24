<?php



return [
    
    'route'         => [
    
        'enabled'    => true,
    
        'attributes' => [
            'prefix'     => 'masters',
            'middleware' => env('MASTER_MIDDLEWARE') ? explode(',', env('MASTER_MIDDLEWARE')) : null,
        ],
    ],

];
