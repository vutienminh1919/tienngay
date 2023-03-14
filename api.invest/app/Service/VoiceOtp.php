<?php


namespace App\Service;


class VoiceOtp
{
    public function __construct()
    {
        $this->brandname_sms_phonenet = env('BRANDNAME_SMS_PHONENET');
        $this->template_phonenet = env('TEMPLATE_PHONENET');
        $this->url_phonenet = env('URL_PHONENET');
        $this->access_key_phonenet = env('ACCESS_KEY_PHONENET');
    }

    public function send_sms_voice_otp($number_phone, $otp)
    {
        $data_sms = array(
            'brandName' => $this->brandname_sms_phonenet,
            'template' => $this->template_phonenet,
            'number' => $number_phone,
            'content' => (string)$otp

        );
        $res = $this->api_phonenet('POST', json_encode($data_sms), '/sms');
        if (isset($res->sendError) && $res->sendError == true) {
            $data['response_update'] = $res;
            $data['type'] = 'SMS_VOICE';
            return 0;
        } else {
            $data['response_update'] = $res;
            $data['type'] = 'SMS_VOICE';
            return 1;
        }
    }

    private function api_phonenet($post = '', $data_post = "", $get = "")
    {
        $service = $this->url_phonenet . $get;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $service);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $post);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'token:' . $this->access_key_phonenet));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result1 = json_decode($result);
        return $result1;
    }

    public function send_sms_voice_otp_v2($number_phone, $otp)
    {
        $data_sms = array(
            'brandName' => $this->brandname_sms_phonenet,
            'template' => $this->template_phonenet,
            'number' => $number_phone,
            'content' => (string)$otp

        );
        $res = $this->api_phonenet('POST', json_encode($data_sms), '/sms/direct');
        return $res;
    }
}
