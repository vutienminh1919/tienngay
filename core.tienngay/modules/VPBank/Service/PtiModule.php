<?php

namespace Modules\VPBank\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

/**
* Endpoint: apiv2.tienngay.vn/pti
*/
class PtiModule
{

    public static function getApiUrl($path) {

        if (env('APP_ENV') == 'dev') {
            return env('CORE_PTI_STAGE') . '/' . $path;
        } elseif (env('APP_ENV') == 'product') {
            return env('CORE_PTI_PROD') . '/' . $path;
        } else {
            return env('CORE_PTI_LOCAL') . '/' . $path;
        }
    }

    /**
     * payment contract request to Api server.
     *
     * @param  Array  $data
     * @return Colection
     */
    public static function bhtnPayment($data, $channel = "vpbank") {
        $url = self::getApiUrl('pti/bhtn/bhtnPayment');
        Log::channel($channel)->info('bhtnPayment start urlApi:  ' . $url);
        $dataPost = array(
            "masterAccountNumber" => $data['masterAccountNumber'],
            "amount" => $data['amount'],
            "remark" => $data['remark'],
            "transactionId" => $data['transactionId'],
            "transactionDate" => $data['transactionDate'],
            "bankName" => "VPBank"
        );
        Log::channel($channel)->info('bhtnPayment data:  ' . print_r($dataPost, true));
        //call api
        $result = Http::withBody( json_encode($dataPost), 'application/json')->post($url, $dataPost);
        Log::channel($channel)->info('bhtnPayment response:  ' . print_r($result->json(), true));
        return $result->json();
    }
}
