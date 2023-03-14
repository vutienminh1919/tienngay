<?php


namespace Modules\AssetTienNgay\Http\Service;


class Upload
{
    public function __construct()
    {
        $this->serviceUpload = env("URL_SERVICE_UPLOAD");
    }

    public function pushUpload($cfile)
    {
        $post = array('avatar' => $cfile);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->serviceUpload);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result1 = json_decode($result);
        return $result1;
    }
}
