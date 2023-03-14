<?php


class TelegramBotHandlerV1
{
	public $token_bot = '';
	public $channel = '';
	public const URL_BOT_API = 'https://api.telegram.org/bot';


	public function __construct($token_bot, $channel)
	{
		$this->token_bot = $token_bot;
		$this->channel = $channel;
	}

	public function sendMessage($message)
	{
		$url_send = self::URL_BOT_API . $this->token_bot . '/sendMessage';
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url_send,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 360,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => 'chat_id=' . $this->channel . '&text=' . $message,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/x-www-form-urlencoded'
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
	}
}
