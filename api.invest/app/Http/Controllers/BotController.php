<?php


namespace App\Http\Controllers;


use App\Service\TelegramBot;
use Illuminate\Http\Request;

class BotController extends Controller
{
    protected $bot;

    public function __construct(TelegramBot $bot)
    {
        $this->bot = $bot;
    }

    public function send_error(Request $request)
    {
        $this->bot->send_error($request->message);
    }
}
