<?php


namespace Modules\CtvTienNgay\Service;


class UploadService
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

    public function check_upload($request)
    {
        $message = [];
        if (empty($_FILES['file'])) {
            $message[] = "File không để trống";
        }

        if (!empty($_FILES['file']) && $_FILES['file']['size'] > 15000000) {
            $message[] = "Kích thước quá lớn";
        }

        $acceptFormat = array("jpeg", "png", "jpg");
        if (!empty($_FILES['file']) && in_array($_FILES['file']['type'], $acceptFormat)) {
            $message[] = "Định dạng không cho phép";
        }
        return $message;
    }

    public function upload($request)
    {
        $data = [];
        if ($_FILES['file']) {
            $cfile = new \CURLFile($_FILES['file']["tmp_name"], $_FILES['file']["type"], $_FILES['file']["name"]);
            $push_upload = $this->pushUpload($cfile);
            if (isset($push_upload->code) && $push_upload->code == 200) {
                $data['path'] = $push_upload->path;
                $data['file_type'] = $_FILES['file']["type"];
                $data['file_name'] = $_FILES['file']["name"];
                $data['key'] = uniqid();
            }
        }
        return $data;
    }
}
