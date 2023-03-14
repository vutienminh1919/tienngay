<?php

return [
    'channels' => [
        'momo' => [
            'driver' => 'daily',
            'path' => storage_path('momo/momo.log'),
            'days' => 365,
        ]
    ]
];
