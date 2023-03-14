<?php


namespace App\Service;


use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class TelegramBot
{
    public function __construct()
    {
        $this->url = "https://api.telegram.org/bot";
        $this->token = '5574112787:AAGwGtq-BGImh6Qn0clNj2pn4Bz_PvoHtfg';
    }

    public function send_error($message)
    {
        $message_new = 'Thời gian: ' . Carbon::now() . ' Phát sinh lỗi: ' . '<b>'.$message .'</b>';
        $chat_id = "-621712184";
        $result = Http::get("https://api.telegram.org/bot" . $this->token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $message_new . "&parse_mode=HTML");
        return json_decode($result->body());
    }

    public function sendError($client, $api, $error, $param)
    {
        $message_new = 'Thời gian: ' . Carbon::now() . "\n" .
            'Client: ' . $client . "\n" .
            'Api: ' . '"<b>' . $api . '</b>"' . "\n" .
            'Phát sinh lỗi: ' . '"<b>' . $error . '</b>"' . "\n" .
            'Data: ' . '"<b>' . $param . '</b>"';
        $chat_id = "-621712184";
        $result = Http::get("https://api.telegram.org/bot" . $this->token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $message_new . "&parse_mode=HTML");
        return json_decode($result->body());
    }
}
