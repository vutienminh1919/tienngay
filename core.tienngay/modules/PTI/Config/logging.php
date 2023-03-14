<?php

return [
    'channels' => [
        'pti' => [
            'driver' => 'daily',
            'path' => storage_path('pti/pti.log'),
            'days' => 365,
        ]
    ]
];
