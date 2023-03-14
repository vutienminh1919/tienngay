<?php

namespace Modules\BlackList\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Modules\BlackList\Service\ApiCall;

/**
* Endpoint: api.tienngay.vn
*/

class BlackListApi
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

    public static function getBlackListProperty()
    {
        $url = self::getApiUrl('property_blacklist/getBlacklistProperty');
        $property = Http::asForm()->post($url);
        Log::channel('BlackList')->info('Response API :'  . print_r($property->json(), true));
        return $property->json();
    }

    public static function getDetailProperty($id)
    {
        $url = self::getApiUrl('property_blacklist/detailBlacklistProperty');
        $property = Http::asForm()->post($url, ['id' => $id]);
        Log::channel('BlackList')->info('Response API :'  . print_r($property->json(), true));
        return $property->json();

    }

    public static function getBlacklistExemtion()
    {
        $url = self::getApiUrl('exemptions/getContractExempted');
        $property = Http::asForm()->post($url);
        Log::channel('BlackList')->info('Response API :'  . print_r($property->json(), true));
        return $property->json();

    }


}
