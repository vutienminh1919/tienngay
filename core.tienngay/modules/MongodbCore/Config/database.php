<?php

return [
    'connections' => [
        'mongodb' => [
            'driver' => 'mongodb',
            'host' => env("MONGODB_HOST", 'mongodb'),
            'port' => env("MONGODB_PORT", 27017),
            'database' => env("MONGODB_DATABASE", "tienngay"),
            'username' => env("MONGODB_USER", "admin"),
            'password' => env("MONGODB_PASSWORD", "leducmanh"),
            'options' => [
                'database' => env("MONGODB_OPTION", "admin"),
            ],
        ],

        'mongodb_report' => [
            'driver' => 'mongodb',
            'host' => env("MONGODB_REPORT_HOST", 'mongodb'),
            'port' => env("MONGODB_REPORT_PORT", 27017),
            'database' => env("MONGODB_REPORT_DATABASE", "tienngay"),
            'username' => env("MONGODB_REPORT_USER", "admin"),
            'password' => env("MONGODB_REPORT_PASSWORD", "12345678"),
            'options' => [
                'database' => env("MONGODB_REPORT_OPTION", "admin"),
            ],
        ],
    ]
];
