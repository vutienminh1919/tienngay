<?php


namespace Modules\AssetLocation\Http\Service;


use Illuminate\Support\Facades\Http;

class Telegram
{
    public static function send($message_new)
    {
        $chat_id = "-648631798";
        $token = "5574112787:AAGwGtq-BGImh6Qn0clNj2pn4Bz_PvoHtfg";
        $result = Http::get("https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $message_new . "&parse_mode=HTML");
        return $result;
    }
}
