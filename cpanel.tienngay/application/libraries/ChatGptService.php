<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ChatGptService
{
    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->config->load('config');
        $this->baseURL = $this->ci->config->item("chatgpt");

    }

    public function chat($msg, $user)
    {
        $service = $this->baseURL . '/openai-gpt/chat';
        $data = [
            'email' => $user['email'],
            'prompt' => trim($msg)
        ];
        $header = [
            'Content-Type:application/json',
            'Authorization:'. $user['token_web']
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $service);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $data = json_decode($result, true);
        if (isset($data["status"]) && $data["status"] == 200) {
            return $data['data'];
        }
        return false;
    }
}
