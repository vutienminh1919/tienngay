<?php

return [
    'channels' => [
        'cpanel' => [
            'driver' => 'daily',
            'path' => storage_path('ViewCpanel/cpanel.log'),
            'days' => 365,
            'tap' => [ modules\ViewCpanel\Logging\CustomizeFormatter::class ],
        ]
    ]
];
