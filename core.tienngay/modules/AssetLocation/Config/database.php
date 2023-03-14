<?php

return [
    'connections' => [
        'mongodb-asset' => [
            'driver' => 'mongodb',
            'host' => env("MONGODB_HOST_ASSET"),
            'port' => env("MONGODB_PORT_ASSET"),
            'database' => env("MONGODB_DATABASE_ASSET"),
            'username' => env("MONGODB_USER_ASSET"),
            'password' => env("MONGODB_PASSWORD_ASSET"),
            'options' => [
                'database' => env("MONGODB_OPTION_ASSET", "admin"),
            ],
        ],
    ]
];
