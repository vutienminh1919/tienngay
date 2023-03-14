<?php

namespace Modules\Heyu\Service;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class ApiCall
{

    /**
    *
    * post api method
    * @param string $url (url service)
    * @param array $data
    * @param array $headerRequest
    * @return array $result
    */
    public static function post($url, $data = [], $headerRequest = []) {
        $header = [
            'Content-Type: application/json'
        ];
        $service = env('HEYU_SERVICE') . $url;
        $header = array_merge($header, $headerRequest);
        $apiKey = env('HEYU_API_KEY');
        $secret = env('HEYU_SECRET');
        $dataJson = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $checksum = md5($dataJson . "+" . $secret);
        $dataRaw = json_encode([
            'apiKey' => $apiKey,
            'checksum' => $checksum,
            'data' => $data
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $curl = curl_init();
        $curl_option = [
            CURLOPT_URL => $service,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $dataRaw,
            CURLOPT_HTTPHEADER => $header,
        ];
        Log::channel('heyu')->info('Curl Option: '. $service . ' dataPost: ' . $dataRaw);
        curl_setopt_array($curl, $curl_option);
        $result = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($result, true);
        Log::channel('heyu')->info('Response Api: '. $service . json_encode($response, JSON_UNESCAPED_UNICODE));
        return $response;
    }

}

