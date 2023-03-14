<?php

return [
    'channels' => [
        'report' => [
            'driver' => 'daily',
            'path' => storage_path('Report/report.log'),
            'days' => 365,
            'tap' => [ modules\Report\Logging\CustomizeFormatter::class ],
        ]
    ]
];
