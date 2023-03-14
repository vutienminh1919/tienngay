<?php


namespace Modules\AssetTienNgay\Http\Service;


class SendEmail
{
    public function __construct()
    {
        $this->URL_API_EMAIL = env('URL_API_EMAIL');
    }

    public function send_Email($data)
    {
        $url_email = $this->URL_API_EMAIL;
        if (isset($data['email'])) {
            $postdata = http_build_query(
                $data
            );
            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'content' => $postdata
                )
            );
            $context = stream_context_create($opts);
            if (!empty($url_email)) {
                $result = file_get_contents($url_email, false, $context);
                $decodeResponse = json_decode($result);
                return $decodeResponse;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
