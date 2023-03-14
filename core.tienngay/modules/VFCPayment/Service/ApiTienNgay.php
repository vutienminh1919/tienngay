<?php

namespace Modules\VFCPayment\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

/**
* Endpoint: api.tienngay.vn
*/
class ApiTienNgay
{
    const CONTRACT_TYPE_TERM = 4;   // thanh toán kỳ api.tienngay transaction['type']
    const CONTRACT_TYPE_FINAL_SETTLEMENT = 3;   // tất toán api.tienngay transaction['type']
    const CONTRACT_TYPE_PAYMENT_TERM = 1;

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
    public static function getPaymentInfo($contractId) {

        //refresh data before get payment amount
        self::refreshContractInfo($contractId);

        $url = self::getApiUrl('payment/get_payment_all_contract');

        $dataPost = array(
            'id' => $contractId,
        );
        //call api
        Log::channel('vfcpayment')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));

        $detainPaymentData = Http::asForm()->post($url, $dataPost);

        Log::channel('vfcpayment')->info('Result Api: ' . $url . ' ' . print_r($detainPaymentData->json(), true));
        return $detainPaymentData;
    }

    /**
     * Refresh contract's debt number to Api server.
     *
     * @param  string  $customerInfo
     * @return Colection
     */
    public static function refreshContractInfo($contractId) {
        $url = self::getApiUrl('payment/payment_all_contract');

        $dataPost = array(
            'id_contract' => $contractId,
        );
        //call api
        Log::channel('vfcpayment')->info('Call Api: ' . $url . ' ' . print_r($dataPost, true));

        $response = Http::asForm()->post($url, $dataPost);

        Log::channel('vfcpayment')->info('Result Api: ' . $url . ' ' . print_r($response->json(), true));
        return $response;
    }
}
