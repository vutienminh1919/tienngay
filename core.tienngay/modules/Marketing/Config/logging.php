<?php

return [
    'channels' => [
        'marketing' => [
            'driver' => 'daily',
            'path' => storage_path('Marketing/marketing.log'),
            'days' => 365,
        ],
    ]
];
