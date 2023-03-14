<?php

return [
    'channels' => [
        'vfcpayment' => [
            'driver' => 'daily',
            'path' => storage_path('VFCPayment/vfcpayment.log'),
            'days' => 365,
            'tap' => [ modules\VFCPayment\Logging\CustomizeFormatter::class ],
        ]
    ]
];
