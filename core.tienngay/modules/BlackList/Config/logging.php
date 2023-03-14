<?php

return [
    'channels' => [
        'blacklist' => [
            'driver' => 'daily',
            'path' => storage_path('BlackList/blacklist.log'),
            'days' => 365,
        ],
    ]
];
