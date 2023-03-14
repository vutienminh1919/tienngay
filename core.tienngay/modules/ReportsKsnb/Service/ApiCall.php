<?php

namespace Modules\ReportsKsnb\Service;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;

class ApiCall {

    private static function generateRequestID() {
        return (string) time() . (string) rand(0, 99);
    }


    public static function getApiUrl($path) {

        if (env('APP_ENV') == 'dev') {
            return env('API_URL_STAGE') . '/' . $path;
        } elseif (env('APP_ENV') == 'product') {
            return env('API_URL_PROD') . '/' . $path;
        } else {
            return env('API_URL_LOCAL') . '/' . $path;
        }
    }

    public static function getUserEmailCht($email)
    {
        $url = self::getApiUrl('role/getEmailCht');
        $data = [
            'email' => $email
        ];
        $getEmail = Http::asForm()->post($url, $data);
        return $getEmail->json();
    }

    public static function getUserEmailAsm($email)
    {
        $url = self::getApiUrl('role/getEmailAsm');
        $data = [
            'email' => $email
        ];
        $getEmail = Http::asForm()->post($url, $data);
        return $getEmail->json();
    }
    public static function getUserEmail($email)
    {
        Log::channel('reportsksnb')->info('Call API getUserEmail :'  . $email);
        $url = self::getApiUrl('role/getUserByEmail_Ksnb');
        $data = [
            'email' => $email
        ];
        $getEmail = Http::asForm()->post($url, $data);
        Log::channel('reportsksnb')->info('Response API getUserEmail :'  . print_r($getEmail->json(), true));
        return $getEmail->json();
    }

    /**
    * send mail to Hcns
    * @param array $data
    * @return Collection
    */
    public static function sendEmaiHcns($data) {
        Log::info('Call API send email hcns :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('reportsksnb.url.sendEmailApi');
        $subject = "Biên Bản Vi Phạm Đã Được Đưa Ra Kết Luận";
        $toEmail = config("reportsksnb.hcns");
        $messageData = [
            "user_name"             => $data['user_name'],
            "user_email"            => array_unique($data['user_email']),
            'user_nv'               => $data['user_nv'],
            "store_name"            => $data['store_name'],
            "code_error"            => $data['code_error'],
            "type"                  => $data['type'],
            "punishment"            => $data['punishment'],
            "discipline"            => $data['discipline'],
            "urlItem"               => $data['urlItem'],
            "description_error"     => !empty($data['description_error']) ? $data['description_error'] : "",
            "description"           => $data['description'],
            "created_by"            => $data['created_by'],
            "position"              => $data['position'],
            "infer"                 => $data['infer'],
        ];
        $dataPost = [
            "message"       =>  view("reportsksnb::mailHcns", $messageData)->render(),
            "toEmail"       => $toEmail,
            "subject"       => $subject,
        ];
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Request API send email hcns  :'  . $url);
        Log::info('Response API send email hcns  :'  . print_r($result->json(), true));
        return $result->json();
    }

    /**
    * send mail wait Confirm Note
    * @param array $data
    * @return Collection
    */
    public static function waitConfirmNote($data) {
        Log::info('Call API send email :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('reportsksnb.url.sendEmailApi');
        foreach ($data['user_email'] as $item) {
            $subject = "Phiếu Ghi Nhận Đang Chờ Duyệt";
            $toEmail = $item;
            $messageData = [
                "name_note"     => $data['name_note'],
                "email_note"    => $data['email_note'],
                'email_nv'      => $data['email_nv'],
                'name_nv'       => $data['name_nv'],
                "store_name"    => $data['store_name'],
                "urlItem"       => $data['urlItem'],
                "created_by"    => $data['created_by'],
                "title"         => $data['title'],
                "content"       => $data['content']
            ];
            $dataPost = [
                "message"       =>  view("reportsksnb::waitConfirmNote", $messageData)->render(),
                "toEmail"       => $toEmail,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            
            Log::info('Request API send email wait confirm note  :'  . $url);
            Log::info('Response API send email wait confirm note  :'  . print_r($result->json(), true));
        }
        return $result->json();
    }


    /**
    * send mail not Confirm Note
    * @param array $data
    * @return Collection
    */
    public static function notConfirmNote($data) {
        Log::info('Call API send email :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('reportsksnb.url.sendEmailApi');
        $subject = "Phiếu Ghi Nhận Chưa Được Duyệt";
        $toEmail = $data['created_by'];
        $messageData = [
            "name_note"     => $data['name_note'],
            "email_note"    => $data['email_note'],
            'email_nv'      => $data['email_nv'],
            'name_nv'       => $data['name_nv'],
            "store_name"    => $data['store_name'],
            "urlItem"       => $data['urlItem'],
            "created_by"    => $data['created_by'],
            "title"         => $data['title'],
            "content"       => $data['content'],
            "reason"        => $data['reason_not_confirm'],
            "name"          => $data['name'],
        ];
        $dataPost = [
            "message"       =>  view("reportsksnb::notConfirmNote", $messageData)->render(),
            "toEmail"       => $toEmail,
            "subject"       => $subject,
        ];

        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Request API send email not confirm note  :'  . $url);
        Log::info('Response API send email not confirm note  :'  . print_r($result->json(), true));
        return $result->json();
    }


    /**
    * send mail reConfirm Note
    * @param array $data
    * @return Collection
    */
    public static function reConfirmNote($data) {
        Log::info('Call API send email :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('reportsksnb.url.sendEmailApi');
        foreach ($data['user_email'] as $item) {
            $subject = "Phiếu Ghi Nhận Đang Chờ Duyệt Lại";
            $toEmail = $item;
            $messageData = [
                "name_note"     => $data['name_note'],
                "email_note"    => $data['email_note'],
                'email_nv'      => $data['email_nv'],
                'name_nv'       => $data['name_nv'],
                "store_name"    => $data['store_name'],
                "urlItem"       => $data['urlItem'],
                "created_by"    => $data['created_by'],
                "title"         => $data['title'],
                "content"       => $data['content']
            ];
            $dataPost = [
                "message"       =>  view("reportsksnb::reConfirmNote", $messageData)->render(),
                "toEmail"       => $toEmail,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            
            Log::info('Request API send email re confirm note  :'  . $url);
            Log::info('Response API send email re confirm note  :'  . print_r($result->json(), true));
        }
        return $result->json();
    }

    /**
    * send mail Confirm Note
    * @param array $data
    * @return Collection
    */
    public static function confirmNote($data) {
        Log::info('Call API send email :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('reportsksnb.url.sendEmailApi');
        
        $subject = "Phiếu Ghi Nhận Đã Được Duyệt";
        $toEmail = $data['toEmail'];
        $messageData = [
            "name_note"     => $data['name_note'],
            "email_note"    => $data['email_note'],
            'email_nv'      => $data['email_nv'],
            'name_nv'       => $data['name_nv'],
            "store_name"    => $data['store_name'],
            "urlItem"       => $data['urlItem'],
            "created_by"    => $data['created_by'],
            "title"         => $data['title'],
            "content"       => $data['content'],
            'name'          => $data['name'],
        ];
        $dataPost = [
            "message"       =>  view("reportsksnb::confirmNote", $messageData)->render(),
            "toEmail"       => $toEmail,
            "subject"       => $subject,
        ];
        $result = Http::asForm()->post($url, $dataPost);
        
        Log::info('Request API send email confirm note  :'  . $url);
        Log::info('Response API send email confirm note  :'  . print_r($result->json(), true));
        
        return $result->json();
    }


    /**
    * send mail user feedback Note
    * @param array $data
    * @return Collection
    */
    public static function userFeedbackNote($data) {
        Log::info('Call API send email :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('reportsksnb.url.sendEmailApi');
        foreach ($data['user_email'] as $item) {
            $subject = "Phiếu Ghi Nhận Đã Được Nhân Viên Phản Hồi";
            $toEmail = $item;
            $messageData = [
                "name_note"     => $data['name_note'],
                "email_note"    => $data['email_note'],
                "emailKsnb"     => array_unique($data['user_email']),
                'email_nv'      => $data['email_nv'],
                'name_nv'       => $data['name_nv'],
                "store_name"    => $data['store_name'],
                "urlItem"       => $data['urlItem'],
                "title"         => $data['title'],
                "content"       => $data['content'],
                "comment"       => $data['comment'],
                "name"          => $data['name'],
            ];
            $dataPost = [
                "message"       => view("reportsksnb::userFeedbackNote", $messageData)->render(),
                "toEmail"       => $toEmail,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            
            Log::info('Request API send email user feedback note  :'  . $url);
            Log::info('Response API send email user feedback note  :'  . print_r($result->json(), true));
        }

        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Request API send email user feedback  :'  . $url);
        Log::info('Response API send email user feedback  :'  . print_r($result->json(), true));
        return $result->json();
    }


    /**
    * send mail ksnb feedback Note
    * @param array $data
    * @return Collection
    */
    public static function ksnbFeedbackNote($data) {
        Log::info('Call API send email :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('reportsksnb.url.sendEmailApi');
        $subject = "Phiếu Ghi Nhận Đã Được Kiểm Soát Nội Bộ Phản Hồi";
        $toEmail = $data['toEmail'];
        $messageData = [
            "name_note"     => $data['name_note'],
            "email_note"    => $data['email_note'],
            "emailKsnb"     => array_unique($data['user_email']),
            'email_nv'      => $data['email_nv'],
            'name_nv'       => $data['name_nv'],
            "store_name"    => $data['store_name'],
            "urlItem"       => $data['urlItem'],
            "title"         => $data['title'],
            "content"       => $data['content'],
            "ksnb_comment"  => $data['ksnb_comment'],
            "name"          => $data['name'],
            "name_nv"       => $data['name_nv'],
        ];
        $dataPost = [
            "message"       => view("reportsksnb::ksnbFeedbackNote", $messageData)->render(),
            "toEmail"       => $toEmail,
            "subject"       => $subject,
        ];
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Request API send email ksnb feedback  :'  . $url);
        Log::info('Response API send email ksnb feedback  :'  . print_r($result->json(), true));
        return $result->json();
    }


    /**
    * send mail wait infer Note
    * @param array $data
    * @return Collection
    */
    public static function waitInferNote($data) {
        Log::info('Call API send email :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('reportsksnb.url.sendEmailApi');
        foreach ($data['user_email'] as $item) {
            $subject = "Phiếu Ghi Nhận Đang Chờ Đưa Ra Kết Luận";
            $toEmail = $item;
            $messageData = [
                "name_note"     => $data['name_note'],
                "email_note"    => $data['email_note'],
                'email_nv'      => $data['email_nv'],
                'name_nv'       => $data['name_nv'],
                "store_name"    => $data['store_name'],
                "urlItem"       => $data['urlItem'],
                "title"         => $data['title'],
                "content"       => $data['content']
            ];
            $dataPost = [
                "message"       =>  view("reportsksnb::waitInferNote", $messageData)->render(),
                "toEmail"       => $toEmail,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            
            Log::info('Request API send email wait infer note  :'  . $url);
            Log::info('Response API send email wait infer note  :'  . print_r($result->json(), true));
        }
        return $result->json();
    }


    /**
    * send mail infer Note
    * @param array $data
    * @return Collection
    */
    public static function inferNote($data) {
        Log::info('Call API send email :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('reportsksnb.url.sendEmailApi');
        $subject = "Phiếu Ghi Nhận Đã Được Đưa Ra Kết Luận";
        $toEmail = $data['toEmail'];
        $messageData = [
            "name_note"     => $data['name_note'],
            "email_note"    => $data['email_note'],
            "emailKsnb"     => array_unique($data['user_email']),
            'email_nv'      => $data['email_nv'],
            'name_nv'       => $data['name_nv'],
            "store_name"    => $data['store_name'],
            "urlItem"       => $data['urlItem'],
            "title"         => $data['title'],
            "content"       => $data['content'],
            "created_by"    => $data['created_by'],
            "infer"         => $data['infer'],
            'name'          => $data['name'],
        ];
        $dataPost = [
            "message"       =>  view("reportsksnb::inferNote", $messageData)->render(),
            "toEmail"       => $toEmail,
            "subject"       => $subject,
        ];
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Request API send email infer note  :'  . $url);
        Log::info('Response API send email infer note  :'  . print_r($result->json(), true));
        return $result->json();
    }


    /**
    * send mail Ceo when ksnb infer
    * @param array $data
    * @return Collection
    */
    public static function sendEmailCeo($data) {
        Log::info('Call API send email :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('reportsksnb.url.sendEmailApi');
        $subject = "Biên Bản Vi Phạm Đang Chờ CEO Xác Nhận";
        $toEmail = "hailm@tienngay.vn";
        $messageData = [
            "user_name"         => $data['user_name'],
            "user_email"        => array_unique($data['user_email']),
            'user_nv'           => $data['user_nv'],
            "store_name"        => $data['store_name'],
            "code_error"        => $data['code_error'],
            "type"              => $data['type'],
            "punishment"        => $data['punishment'],
            "discipline"        => $data['discipline'],
            "urlItem"           => $data['urlItem'],
            "description_error" => $data['description_error'],
            "description"       => $data['description'],
            "position"          =>$data['position'],
            "infer"             =>$data['infer'],
        ];
        $dataPost = [
            "message"       =>  view("reportsksnb::sendCeoRp", $messageData)->render(),
            "toEmail"       => $toEmail,
            "subject"       => $subject,
        ];

        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Request API send email ceo  :'  . $url);
        Log::info('Response API send email ceo  :'  . print_r($result->json(), true));
        return $result->json();
    }

    public static function ceoNotConfirm($data) {
        Log::info('Call API send email :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('reportsksnb.url.sendEmailApi');
        foreach ($data['user_email'] as $item) {
            $subject = "Biên Bản Vi Phạm Chưa Được CEO Xác Nhận";
            $toEmail = $item;
            $messageData = [
                "user_name"         => $data['user_name'],
                'user_nv'           => $data['user_nv'],
                "store_name"        => $data['store_name'],
                "code_error"        => $data['code_error'],
                "type"              => $data['type'],
                "punishment"        => $data['punishment'],
                "discipline"        => $data['discipline'],
                "urlItem"           => $data['urlItem'],
                "description_error" => $data['description_error'],
                "description"       => $data['description'],
                "ceo_not_confirm"   => $data['ceo_not_confirm'],
                "position"          => $data['position'],
            ];
            $dataPost = [
                "message"       =>  view("reportsksnb::ceoNotConfirm", $messageData)->render(),
                "toEmail"       => $toEmail,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            Log::info('Request API send email ceo not confirm  :'  . $url);
            Log::info('Response API send email  ceo not confirm  :'  . print_r($result->json(), true));
        }

        return $result->json();
    }


    public static function ceoConfirm($data) {
        Log::info('Call API send email :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('reportsksnb.url.sendEmailApi');
        $subject = "Biên Bản Vi Phạm Đã Được CEO Xác Nhận";
        $toEmail = $data['toEmail'];
        $messageData = [
            "user_name"         => $data['user_name'],
            'user_nv'           => $data['user_nv'],
            "store_name"        => $data['store_name'],
            "code_error"        => $data['code_error'],
            "type"              => $data['type'],
            "punishment"        => $data['punishment'],
            "discipline"        => $data['discipline'],
            "urlItem"           => $data['urlItem'],
            "description_error" => $data['description_error'],
            "description"       => $data['description'],
            "ceo_confirm"       => $data['ceo_confirm'],
            "position"          => $data['position'],
            "infer"             => $data['infer'],
            'toEmail'           => $data['toEmail'],
        ];
        $dataPost = [
            "message"       =>  view("reportsksnb::ceoConfirm", $messageData)->render(),
            "toEmail"       => $toEmail,
            "subject"       => $subject,
        ];
        $result = Http::asForm()->post($url, $dataPost);
        Log::info('Request API send email infer note  :'  . $url);
        Log::info('Response API send email infer note  :'  . print_r($result->json(), true));
        return $result->json();
    }

}

