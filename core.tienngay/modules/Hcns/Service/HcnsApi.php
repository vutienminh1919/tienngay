<?php

namespace Modules\Hcns\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Modules\Hcns\Service\ApiCall;

/**
* Endpoint: api.tienngay.vn
*/

class HcnsApi
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

    public static function getUserHcns()
    {
        $url = self::getApiUrl('role/getUserHcns');
        $getEmail = Http::asForm()->post($url);
        Log::channel('hcns')->info('Response API getUserHcns :'  . print_r($getEmail->json(), true));
        return $getEmail->json();
    }
}
