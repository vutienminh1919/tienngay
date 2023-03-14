<?php

return [
    'channels' => [
        'macom' => [
            'driver' => 'daily',
            'path' => storage_path('Macom/macom.log'),
            'days' => 365,
        ],
    ]
];
