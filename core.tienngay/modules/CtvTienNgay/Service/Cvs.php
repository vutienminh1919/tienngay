<?php

namespace Modules\CtvTienNgay\Service;


class Cvs
{
    public function __construct()
    {
        $this->url = env('CVS_URL');
        $this->user = env('CVS_API_USER');
        $this->password = env('CVS_API_PASSWORD');
    }

    public function call_api($url_api)
    {
        $ch = curl_init($url_api);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->user . ":" . $this->password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $respone_data = curl_exec($ch);
        curl_close($ch);
        $result1 = json_decode($respone_data);
        return $result1;
    }

    // trich xuat 2 mat cmt/cccd dau vao la file anh
    public function ekyc_cards($data)
    {
        $front_card = !empty($data['front_card']) ? $data['front_card'] : '';
        $back_card = !empty($data['back_card']) ? $data['back_card'] : '';
//        $url_api = $this->url . 'ocr/cmt/get_haimat?mattruoc=' . $front_card . '&matsau=' . $back_card;
        $url_api = $this->url . 'api/v2/ekyc/cards?img1=' . $front_card . '&img2=' . $back_card . "&format_type=url&get_thumb=true";
        $data = $this->call_api($url_api);
        return $data;
    }

}
