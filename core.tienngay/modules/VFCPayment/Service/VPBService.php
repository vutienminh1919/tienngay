<?php

namespace Modules\VFCPayment\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class VPBService
{

    public static function getApiUrl($path) {

        if (env('APP_ENV') == 'dev') {
            return env('CORE_VPBANK_STAGE') . '/' . $path;
        } elseif (env('APP_ENV') == 'product') {
            return env('CORE_VPBANK_PROD') . '/' . $path;
        } else {
            return env('CORE_VPBANK_LOCAL') . '/' . $path;
        }
    }

    /**
    *
    * Create or get virtual account number by code_contract
    * @param String $codeContract
    * @return Array
    */
    public static function assignVan($codeContract)
    {
        Log::channel('vfcpayment')->info('VPBank assignVan method start');
        if (empty($codeContract)) {
            Log::channel('vfcpayment')->info('VPBank assignVan method: codeContract is empty');
            return false;
        }
        $service = self::getApiUrl('vpbank/getVan');
        $data = [
            'contract_code' => $codeContract,
        ];
        Log::channel('vfcpayment')->info('VPBank assignVan method: request ' . $service . print_r($data, true));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $service);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result, true);
        Log::channel('vfcpayment')->info('VPBank assignVan method: response ' . print_r($data, true));
        if (isset($data["status"]) && $data["status"] == 200) {
            return $data['data']["van"];
        }
        Log::channel('vfcpayment')->info('VPBank assignVan method: get VAN failed');
        return false;
    }
}
