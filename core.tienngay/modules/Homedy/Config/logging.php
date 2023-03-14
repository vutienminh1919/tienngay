<?php

return [
    'channels' => [
        'homedy' => [
            'driver' => 'daily',
            'path' => storage_path('homedy/homedy.log'),
            'days' => 365,
        ]
    ]
];
