<?php

return [
    'channels' => [
        'appkh' => [
            'driver' => 'daily',
            'path' => storage_path('Appkh/appkh.log'),
            'days' => 365,
        ],
    ]
];
