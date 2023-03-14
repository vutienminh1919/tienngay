<?php

namespace Modules\Tenancy\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Modules\MongodbCore\Entities\KsnbCodeError;
use Modules\Tenancy\Service\ApiCall;

/**
* Endpoint: api.tienngay.vn
*/

class tenancyApi
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

        public static function sendEmailTenancy($data) {
        $url = env('MAILER_LOCAL') . '/'. config('tenancy.url.sendMailTenancy');
        $subject = "Quản lý hợp đồng thuê mặt bằng";
        $toEmail = config('tenancy.keToan');
        foreach ($toEmail as $i) {
                $messageData = [
                    'data' => $data,
                    'user_email' => $i
                ];
            $dataPost = [
                "message" => view("tenancy::QuaHan", $messageData)->render(),
                "toEmail" => $i,
                "subject" => $subject,
            ];
         $result = Http::asForm()->post($url, $dataPost);
        }
        return $result->json();
    }

    public static function send_email_tenancy($data)
    {
        $url = env('MAILER_LOCAL') . '/' . config('tenancy.url.sendMailTenancy');
        $subject = "Quản lý hợp đồng thuê mặt bằng";
        $toEmail = config('tenancy.keToan');
        foreach ($toEmail as $i) {
            $messageData = [
                'data' => $data,
                'user_email' => $i
            ];
            $dataPost = [
                "message" => view("tenancy::ToiHan", $messageData)->render(),
                "toEmail" => $i,
                "subject" => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
        }
        return $result->json();
    }

    public static function send_email_notification($data)
    {
        $url = env('MAILER_LOCAL') . '/' . config('tenancy.url.sendMailTenancy');
        $subject = "Danh sách hợp đồng cần thanh toán";
        $toEmail = config('tenancy.keToan');
        foreach ($toEmail as $i) {
            $messageData = [
                'data' => $data,
                'user_email' => $i
            ];
            $dataPost = [
                "message" => view("tenancy::Notification", $messageData)->render(),
                "toEmail" => $i,
                "subject" => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
        }
        return $result->json();
    }

}
