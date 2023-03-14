<?php

namespace Modules\PTI\Service;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
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
            'UserName: ' . env('PTI_USERNAME'),
            'PassWord: ' . env('PTI_PASSWORD'),
            'SecretKey: ' . env('PTI_SECRET_KEY'),
            'Channel: ' . env('PTI_CHANNEL'),
            'BranchUnit: ' . env('PTI_BRANCH_UNIT'),
            'Content-Type: application/json'
        ];
        if (env('PTI_BLOCKCODE')) {
            $header[] = 'BlockCode: ' . env('PTI_BLOCKCODE');
        } else {
            $header[] = 'BlockCode;';
        }
        $service = env('PTI_SERVICE') . $url;
        if ($url == env('PTI_SIGNORDER_PATH')) {
            $service = $url;
        }
        $header = array_merge($header, $headerRequest);
        $dataRaw = json_encode(["data" => json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
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
        Log::channel('pti')->info('Curl Option: '. $service . ' dataPost: ' . $dataRaw);
        Log::channel('pti')->info('Curl Option: '. $service . print_r($curl_option, true));
        curl_setopt_array($curl, $curl_option);

        $result = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($result, true);

        Log::channel('pti')->info('Response Api: '. $service . json_encode($response));
        return $response;
    }

    /**
    *
    * post BHTN api method
    * @param string $url (url service)
    * @param array $data
    * @param array $headerRequest
    * @return array $result
    */
    public static function postBHTN($url, $data = [], $headerRequest = [], $channel = "pti") {
        $header = [
            'UserName: ' . env('PTI_BHTN_USERNAME'),
            'PassWord: ' . env('PTI_BHTN_PASSWORD'),
            'SecretKey: ' . env('PTI_BHTN_SECRET_KEY'),
            'Channel: ' . env('PTI_BHTN_CHANNEL'),
            'BranchUnit: ' . env('PTI_BHTN_BRANCH_UNIT'),
            'Content-Type: application/json'
        ];
        if (env('PTI_BLOCKCODE')) {
            $header[] = 'BlockCode: ' . env('PTI_BLOCKCODE');
        } else {
            $header[] = 'BlockCode;';
        }
        $service = env('PTI_SERVICE') . $url;
        $header = array_merge($header, $headerRequest);
        $dataRaw = json_encode(
            [
                "data" => json_encode($data['data'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                "ds_dk" => json_encode($data['ds_dk'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                "ds_tra" => json_encode($data['ds_tra'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                "encrypt" => json_encode($data['encrypt'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            ], 
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
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
        Log::channel($channel)->info('Curl Option: '. $service . ' dataPost: ' . $dataRaw);
        Log::channel($channel)->info('Curl Option: '. $service . print_r($curl_option, true));
        curl_setopt_array($curl, $curl_option);

        $result = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($result, true);

        Log::channel($channel)->info('Response postBHTN Api: '. $service . print_r($response, true));
        return $response;
    }

    /**
    *
    * get gcn
    * @param string $url (url service)
    * @param array $data
    * @param array $headerRequest
    * @return array $result
    */
    public static function getBHTNGCN($url, $data = [], $headerRequest = [], $channel = "pti") {
        $header = [
            'UserName: ' . env('PTI_BHTN_USERNAME'),
            'PassWord: ' . env('PTI_BHTN_PASSWORD'),
            'SecretKey: ' . env('PTI_BHTN_SECRET_KEY'),
            'Channel: ' . env('PTI_BHTN_CHANNEL'),
            'BranchUnit: ' . env('PTI_BHTN_BRANCH_UNIT_SIGNORDER'),
            'Content-Type: application/json'
        ];
        if (env('PTI_BLOCKCODE')) {
            $header[] = 'BlockCode: ' . env('PTI_BLOCKCODE');
        } else {
            $header[] = 'BlockCode;';
        }
        $service = $url;
        $header = array_merge($header, $headerRequest);
        $dataRaw = json_encode(["data" => json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
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
        Log::channel($channel)->info('Curl Option: '. $service . ' dataPost: ' . $dataRaw);
        Log::channel($channel)->info('Curl Option: '. $service . print_r($curl_option, true));
        curl_setopt_array($curl, $curl_option);

        $result = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($result, true);

        Log::channel($channel)->info('Response getBHTNGCN Api: ' . $service . print_r($response, true));
        return $response;
    }

    /**
    *
    * confirm order
    * @param string $url (url service)
    * @param array $data
    * @param array $headerRequest
    * @return array $result
    */
    public static function confirmBHTN($url, $data = [], $headerRequest = [], $channel = "pti") {
        $header = [
            'UserName: ' . env('PTI_BHTN_USERNAME'),
            'PassWord: ' . env('PTI_BHTN_PASSWORD'),
            'SecretKey: ' . env('PTI_BHTN_SECRET_KEY'),
            'Channel: ' . env('PTI_BHTN_CHANNEL'),
            'Content-Type: application/json'
        ];
        if (env('PTI_BLOCKCODE')) {
            $header[] = 'BlockCode: ' . env('PTI_BLOCKCODE');
        } else {
            $header[] = 'BlockCode;';
        }
        $service = env('PTI_SERVICE') . $url;
        $header = array_merge($header, $headerRequest);
        $dataRaw = json_encode(["data" => json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
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
        Log::channel($channel)->info('Curl Option: '. $service . ' dataPost: ' . $dataRaw);
        Log::channel($channel)->info('Curl Option: '. $service . print_r($curl_option, true));
        curl_setopt_array($curl, $curl_option);

        $result = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($result, true);

        Log::channel($channel)->info('Response getBHTNGCN Api: ' . $service . print_r($response, true));
        return $response;
    }

}

