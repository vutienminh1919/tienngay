<?php

return [
    'channels' => [
        'heyu' => [
            'driver' => 'daily',
            'path' => storage_path('heyu/heyu.log'),
            'days' => 365,
        ]
    ]
];
