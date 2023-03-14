<?php

return [
    'channels' => [
        'Tenancy' => [
            'driver' => 'daily',
            'path' => storage_path('Tenancy/Tenancy.log'),
            'days' => 365,
            'tap' => [ modules\Tenancy\Logging\CustomizeFormatter::class ],
        ],
    ]
];
