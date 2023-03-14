<?php

return [
    'channels' => [
        'paymentholiday' => [
            'driver' => 'daily',
            'path' => storage_path('paymentholiday/paymentholiday.log'),
            'days' => 365,
        ]
    ]
];
