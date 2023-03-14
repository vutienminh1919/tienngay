<?php

return [
    'channels' => [
        'hcns' => [
            'driver' => 'daily',
            'path' => storage_path('Hcns/hcns.log'),
            'days' => 365,
        ],
    ]
];
