<?php

return [
    'channels' => [
        'vpbank' => [
            'driver' => 'daily',
            'path' => storage_path('vpbank/vpbank.log'),
            'days' => 365,
        ]
    ]
];
