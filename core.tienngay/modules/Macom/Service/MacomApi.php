<?php

namespace Modules\Macom\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Modules\Macom\Service\ApiCall;

/**
* Endpoint: api.tienngay.vn
*/

class MacomApi
{

    public static function getApiUrl($path) {

        if (env('APP_ENV') == 'dev') {
            return env('API_URL_STAGE') . '/' . $path;
        } elseif (env('APP_ENV') == 'product') {
            return env('API_URL_PROD') . '/' . $path;
        } else {
            return env('API_URL_LOCAL') . '/' . $path;
        }
    }

    /**
     * Get contract information from Api server.
     *
     * @param  string  $contractId
     * @return Colection
     */
}
