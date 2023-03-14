<?php

return [
    'name' => 'VPBank',
    'errorCode' => [
        'success'                       => 200,
        'duplicate_transaction_id'      => 1,
        'authen_failed'                 => 2,
        'timeout'                       => 3,
        'other'                         => 4,
        'invalid_data'                  => 5,
        'invalid_signature'             => 6,
        'retry_success'                 => 200,
    ],
    'create_update_error' => [
        'van_already_exists' => '01',
    ],
    'company' => [
        'tcv' => '00012',
        'tcvdb' => '00015',
    ],
];
