<?php


namespace App\Service;


use Illuminate\Support\Facades\Http;

class ApiCpanel
{
    public static function post($url, $data = [])
    {
        $url_api = env('URL_API_CPANEL') . $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_api);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($data));
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }
}
