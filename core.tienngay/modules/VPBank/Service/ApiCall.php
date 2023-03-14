<?php

namespace Modules\VPBank\Service;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;

class ApiCall
{

    /**
    *
    * post vpb api method
    * @param string $url (url service)
    * @param array $data
    * @param array $headerRequest
    * @param boolean $tcvdb (tai chinh viet dong bac)
    * @return array $result
    */
    public static function post($url, $data = [], $headerRequest = [], $tcvdb = false) {
        if ($tcvdb) {
            $token = Cookie::get('vpb_tcvdb_token');
        } else {
            $token = Cookie::get('vpb_tcv_token');
        }
        if (!$token) {
            // get new token
            $token = self::getToken($tcvdb);
        }
        $header = [
            'X-Request-Id: ' . self::generateRequestID(),
            'Authorization: ' . 'Bearer ' . $token,
        ];
        $service = env('VPB_SERVICE') . $url;
        $header = array_merge($header, $headerRequest);
        $dataRaw = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        Log::channel('vpbank')->info('Call Api: '. env('API_URL') . $service . print_r($dataRaw, true));
        Log::channel('vpbank')->info('Call Api HEADER: '. print_r($header, true));
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
        Log::channel('vpbank')->info('Curl Option: '. env('API_URL') . $service . print_r($curl_option, true));
        curl_setopt_array($curl, $curl_option);

        $result = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($result, true);

        Log::channel('vpbank')->info('Response Api: '. env('API_URL') . $service . print_r($response, true));

        if (
            isset($response["virtualAccId"]) 
            || (isset($response["error"]) && $response["error"] === config('vpbank.create_update_error.van_already_exists'))
        ) {
            return $response;
        }

        //call second time if response had error
        $token = self::getToken($tcvdb);
        $header = [
            'X-Request-Id: ' . self::generateRequestID(),
            'Authorization: ' . 'Bearer ' . $token,
        ];
        $service = env('VPB_SERVICE') . $url;
        $header = array_merge($header, $headerRequest);
        $dataRaw = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        Log::channel('vpbank')->info('Call Api 2nd: '. env('API_URL') . $service . print_r($dataRaw, true));
        Log::channel('vpbank')->info('Call Api 2nd HEADER: '. print_r($header, true));
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
        Log::channel('vpbank')->info('Curl Option: '. env('API_URL') . $service . print_r($curl_option, true));
        curl_setopt_array($curl, $curl_option);

        $result = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($result, true);
        Log::channel('vpbank')->info('Response Api 2nd: '. env('API_URL') . $service . print_r($response, true));

        if ($response && !isset($response["error"])) {
            return $response;
        }
        return null;
    }

    /**
    *
    * post vpb api method
    * @param string $url (url service)
    * @param array $data
    * @param array $headerRequest
    * @param boolean $tcvdb (tai chinh viet dong bac)
    * @return string $token
    */
    public static function put($url, $data = [], $headerRequest = [], $tcvdb = false) {
        if ($tcvdb) {
            $token = Cookie::get('vpb_tcvdb_token');
        } else {
            $token = Cookie::get('vpb_tcv_token');
        }
        if (!$token) {
            // get new token
            $token = self::getToken($tcvdb);
        }
        $header = [
            'X-Request-Id: ' . self::generateRequestID(),
            'Authorization: ' . 'Bearer ' . $token,
        ];
        $service = env('VPB_SERVICE') . $url;
        $header = array_merge($header, $headerRequest);
        $dataRaw = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        Log::channel('vpbank')->info('Call Api: '. env('API_URL') . $service . print_r($dataRaw, true));
        Log::channel('vpbank')->info('Call Api HEADER: '. print_r($header, true));
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
        Log::channel('vpbank')->info('Curl Option: '. env('API_URL') . $service . print_r($curl_option, true));
        curl_setopt_array($curl, $curl_option);

        $result = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($result, true);

        Log::channel('vpbank')->info('Response Api: '. env('API_URL') . $service . print_r($response, true));

        if (
            isset($response["virtualAccId"]) 
            || (isset($response["error"]) && $response["error"] === config('vpbank.create_update_error.van_already_exists'))
        ) {
            return $response;
        }

        //call second time if response had error
        $token = self::getToken($tcvdb);
        $header = [
            'X-Request-Id: ' . self::generateRequestID(),
            'Authorization: ' . 'Bearer ' . $token,
        ];
        $service = env('VPB_SERVICE') . $url;
        $header = array_merge($header, $headerRequest);
        $dataRaw = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        Log::channel('vpbank')->info('Call Api 2nd: '. env('API_URL') . $service . print_r($dataRaw, true));
        Log::channel('vpbank')->info('Call Api 2nd HEADER: '. print_r($header, true));
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
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $dataRaw,
            CURLOPT_HTTPHEADER => $header,
        ];
        Log::channel('vpbank')->info('Curl Option: '. env('API_URL') . $service . print_r($curl_option, true));
        curl_setopt_array($curl, $curl_option);

        $result = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($result, true);
        Log::channel('vpbank')->info('Response Api 2nd: '. env('API_URL') . $service . print_r($response, true));

        if ($response && !isset($response["error"])) {
            return $response;
        }
        return null;
    }

    /**
    *
    * generate unique string
    * @return string
    */
    private static function generateRequestID() {
        return (string) time() . (string) rand(0, 99);
    }

    /**
    *
    * Get Vpbank Authorization token
    * @param boolean $tcvdb (tai chinh viet dong bac)
    * @return string $token
    */
    private static function getToken($tcvdb = false) {
        $service = env('VPB_SERVICE').'/security/token';
        if ($tcvdb) {
            // Tai Chinh Viet Dong Bac
            $user = env('VPB_TCVDB_AUTH_USER');
            $password = env('VPB_TCVDB_AUTH_PASSWORD');
        } else {
            // Tai Chinh Viet
            $user = env('VPB_TCV_AUTH_USER');
            $password = env('VPB_TCV_AUTH_PASSWORD');
            
        }
        $dataPost = array(
            'grant_type' => env('VPB_GRANT_TYPE'),
        );
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($user . ':' . $password)
        );
        Log::channel('vpbank')->info('(call service): '. $service);
        Log::channel('vpbank')->info('(headers): '. print_r($headers, true));
        Log::channel('vpbank')->info('(dataPost): '. print_r($dataPost, true));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $service);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dataPost));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        Log::channel('vpbank')->info('(ch): '. print_r($ch, true));
        Log::channel('vpbank')->info('(getToken): '. $result);
        $response = json_decode($result, true);
        $token = isset($response['access_token']) ? $response['access_token'] : '';
        if ($token) {
            if ($tcvdb) {
                // Tai Chinh Viet Dong Bac
                Cookie::make('vpb_tcvdb_token', $token, time() + (86400 * 30)); // 30days
            } else {
                // Tai Chinh Viet
                Cookie::make('vpb_tcv_token', $token, time() + (86400 * 30)); // 30days
                
            }
        }
        return $token;
    }

    /**
    *
    * Get user app code
    * @param boolean $tcvdb (tai chinh viet dong bac)
    * @return string $appCode
    */
    private static function appCode($tcvdb = false) {
        if ($tcvdb) {
            // Tai Chinh Viet Dong Bac
            return env('VPB_TCVDB_PARTNER');
        } else {
            // Tai Chinh Viet
            return env('VPB_TCV_PARTNER');
            
        }
    }

}

