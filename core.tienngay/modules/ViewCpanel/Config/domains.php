<?php

// local environment
$local = [
    'apicpanel'             => env('CORE_API_LOCAL') . '/api/',
    'paymentgateway'        => env('CORE_PAYMENTGATEWAY_LOCAL') . '/paymentgateway/',
    'vpbank'				=> env('CORE_VPBANK_LOCAL') . '/vpbank/',
    'report'                => env('CORE_REPORT_LOCAL') . '/report/',
    'api'                   => env('API_URL_LOCAL') . '/',
    'reportsksnb'           => env('REPORTKSNB_LOCAL').'/reportsksnb/',
    'pti'                   => env('CORE_PTI_LOCAL').'/pti/',
    'hcns'                  => env('HCNS_LOCAL').'/hcns/',
    'blacklist'             => env('BLACKLIST_LOCAL').'/blacklist/',
    'toolSendEmail'         => env('MAILER_LOCAL').'/mailer/',
    'heyu'                  => env('HEYU_LOCAL'). '/heyu/',
    'macom'                 => env('MACOM_LOCAL'). '/macom/',
    'paymentHolidays'       => env('PAYMENT_HOLIDAYS_LOCAL'). '/payment-holiday/',
    'trade'                 => env('TRADE_LOCAL'). '/marketing/trade/',
    'warehouse'             => env('WAREHOUSE_LOCAL'). '/marketing/warehouse/'
];

// development environment
$dev = [
    'apicpanel'             => env('CORE_API_STAGE') . '/api/',
    'paymentgateway'        => env('CORE_PAYMENTGATEWAY_STAGE') . '/paymentgateway/',
    'vpbank'				=> env('CORE_VPBANK_STAGE') . '/vpbank/',
    'report'                => env('CORE_REPORT_STAGE') . '/report/',
    'api'                   => env('API_URL_STAGE') . '/',
    'reportsksnb'           => env('REPORTKSNB_STAGE').'/reportsksnb/',
    'pti'                   => env('CORE_PTI_STAGE').'/pti/',
    'hcns'                  => env('HCNS_STAGE').'/hcns/',
    'blacklist'             => env('BLACKLIST_STAGE').'/blacklist/',
    'toolSendEmail'         => env('MAILER_STAGE').'/mailer/',
    'heyu'                  => env('HEYU_STAGE'). '/heyu/',
    'macom'                 => env('MACOM_STAGE'). '/macom/',
    'paymentHolidays'       => env('PAYMENT_HOLIDAYS_STAGE'). '/payment-holiday/',
    'trade'                 => env('TRADE_STAGE'). '/marketing/trade/',
    'warehouse'             => env('WAREHOUSE_STAGE'). '/marketing/warehouse/'
];

//product environment
$product = [
    'apicpanel'             => env('CORE_API_PROD') . '/api/',
    'paymentgateway'        => env('CORE_PAYMENTGATEWAY_PROD'). '/paymentgateway/',
    'vpbank'				=> env('CORE_VPBANK_PROD') . '/vpbank/',
    'report'                => env('CORE_REPORT_PROD') . '/report/',
    'api'                   => env('API_URL_PROD') . '/',
    'reportsksnb'           => env('REPORTKSNB_PROD').'/reportsksnb/',
    'pti'                   => env('CORE_PTI_PROD').'/pti/',
    'hcns'                  => env('HCNS_PROD').'/hcns/',
    'blacklist'             => env('BLACKLIST_PROD').'/blacklist/',
    'toolSendEmail'         => env('MAILER_PROD').'/mailer/',
    'heyu'                  => env('HEYU_PROD'). '/heyu/',
    'macom'                 => env('MACOM_PROD'). '/macom/',
    'paymentHolidays'       => env('PAYMENT_HOLIDAYS_PROD'). '/payment-holiday/',
    'trade'                 => env('TRADE_PROD'). '/marketing/trade/',
    'warehouse'             => env('WAREHOUSE_PROD'). '/marketing/warehouse/'
];


if (env('APP_ENV') == 'dev') {
    return $dev;
} elseif (env('APP_ENV') == 'product') {
    return $product;
} else {
    return $local;
}
