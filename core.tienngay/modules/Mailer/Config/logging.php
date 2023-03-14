<?php

return [
    'channels' => [
        'mailer' => [
            'driver' => 'daily',
            'path' => storage_path('mailer/mailer.log'),
            'days' => 365,
        ],
        'cronjob-mailer' => [
            'driver' => 'daily',
            'path' => storage_path('cronjob-mailer/mailer.log'),
            'days' => 365,
        ]
    ]
];
