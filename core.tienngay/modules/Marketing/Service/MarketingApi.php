<?php

namespace Modules\Marketing\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Modules\Hcns\Service\ApiCall;

/**
* Endpoint: api.tienngay.vn
*/

class MarketingApi
{

    public static function getApiUrl($path) {

        if (env('APP_ENV') == 'dev') {
            return env('API_URL_STAGE') . '/' . $path;
        } elseif (env('APP_ENV') == 'product') {
            return env('API_URL_PROD') . '/' . $path;
        } else {
            return env('API_URL_LOCAL') . '/' . $path;
        }
    }

    public static function sendRequestOrder($data) {
        Log::info('Call API send email requestOrder :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('marketing.url.sendMailTrade');
        $subject = "[THÔNG BÁO] - Phiếu Yêu Cầu Ấn Phẩm Đã Được Tạo";
        foreach ($data['user'] as $email) {
            $messageData = [
                "plan_name"             => $data['plan_name'],
                "url"                   => $data['url'],
                "subject"               => $subject,
                "store_name"            => $data['store_name'],
            ];
            $dataPost = [
                "message"       =>  view("marketing::sendEmailRequestOrderToAsm", $messageData)->render(),
                "toEmail"       => $email,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            Log::info('Request API send email requestOrder  :'  . $url);
            Log::info('Response API send email requestOrder  :'  . print_r($result->json(), true));
        }
        return true;
    }

    public static function sendConfirmRequestOrder($data) {
        Log::info('Call API send email requestOrder :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('marketing.url.sendMailTrade');
        $subject = "[THÔNG BÁO] - Phiếu Yêu Cầu Ấn Phẩm Đang Chờ Xác Nhận";
        foreach ($data['user'] as $email) {
            $messageData = [
                "plan_name"             => $data['plan_name'],
                "url"                   => $data['url'],
                "subject"               => $subject,
                "store_name"            => $data['store_name'],
            ];
            $dataPost = [
                "message"       =>  view("marketing::sendEmailRequestOrderConfirm", $messageData)->render(),
                "toEmail"       => $email,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            Log::info('Request API send email requestOrder  :'  . $url);
            Log::info('Response API send email requestOrder  :'  . print_r($result->json(), true));
        }
        return true;
    }

    public static function sendEmailToManager($data) {
        Log::info('Call API send email requestOrder :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('marketing.url.sendMailTrade');
        $subject = "[THÔNG BÁO] - Ngân Sách Dự Toán Yêu Cầu Ấn Phẩm Đang Chờ Xác Nhận";
        foreach ($data['user'] as $email) {
            $messageData = [
                "user"                  => $email,
                "plan_name"             => $data['plan_name'],
                "url"                   => $data['url'],
                "subject"               => $subject,
            ];
            $dataPost = [
                "message"       =>  view("marketing::sendEmailRequestOrderToCfo", $messageData)->render(),
                "toEmail"       => $email,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            Log::info('Request API send email requestOrder  :'  . $url);
            Log::info('Response API send email requestOrder  :'  . print_r($result->json(), true));
        }
        return true;
    }

    public static function sendEmailToGdkdMkt($data) {
        Log::info('Call API send email requestOrder :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('marketing.url.sendMailTrade');
        $subject = "[THÔNG BÁO] - Ngân Sách Dự Toán Yêu Cầu Ấn Phẩm Được Tạo Thành Công";
        foreach ($data['user'] as $email) {
            $messageData = [
                "user"                  => $email,
                "plan_name"             => $data['plan_name'],
                "url"                   => $data['url'],
                "subject"               => $subject,
            ];
            $dataPost = [
                "message"       =>  view("marketing::sendEmailRequestOrderToGdkd", $messageData)->render(),
                "toEmail"       => $email,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            Log::info('Request API send email requestOrder  :'  . $url);
            Log::info('Response API send email requestOrder  :'  . print_r($result->json(), true));
        }
        return true;
    }

    public static function sendEmailToCeo($data) {
        Log::info('Call API send email requestOrder :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('marketing.url.sendMailTrade');
        $subject = "[THÔNG BÁO] - Ngân Sách Dự Toán Yêu Cầu Ấn Phẩm Đang Chờ Xác Nhận";
        foreach ($data['user'] as $email) {
            $messageData = [
                "user"                  => $email,
                "plan_name"             => $data['plan_name'],
                "url"                   => $data['url'],
                "subject"               => $subject,
            ];
            $dataPost = [
                "message"       =>  view("marketing::sendEmailRequestOrderToCeo", $messageData)->render(),
                "toEmail"       => $email,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            Log::info('Request API send email requestOrder  :'  . $url);
            Log::info('Response API send email requestOrder  :'  . print_r($result->json(), true));
        }
        return true;
    }

    public static function sendEmailToHcns($data) {
        Log::info('Call API send email requestOrder :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('marketing.url.sendMailTrade');
        $subject = "[THÔNG BÁO] - Ngân Sách Dự Toán Yêu Cầu Ấn Phẩm Đã Được Phê Duyệt";
        foreach ($data['user'] as $email) {
            $messageData = [
                "plan_name"             => $data['plan_name'],
                "url"                   => $data['url'],
                "subject"               => $subject,
            ];
            $dataPost = [
                "message"       =>  view("marketing::sendEmailRequestOrderToHcns", $messageData)->render(),
                "toEmail"       => $email,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            Log::info('Request API send email requestOrder  :'  . $url);
            Log::info('Response API send email requestOrder  :'  . print_r($result->json(), true));
        }
        return true;
    }

    public static function sendRequestOrderReturn($data) {
        Log::info('Call API send email requestOrder :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('marketing.url.sendMailTrade');
        $subject = "[THÔNG BÁO] - Phiếu Yêu Cầu Ấn Phẩm Chưa Được Xác Nhận";
        foreach ($data['user'] as $email) {
            $messageData = [
                "plan_name"             => $data['plan_name'],
                "url"                   => $data['url'],
                "subject"               => $subject,
                "store_name"            => $data['store_name'] ?? "",
            ];
            $dataPost = [
                "message"       =>  view("marketing::sendEmailRequestOrderReturn", $messageData)->render(),
                "toEmail"       => $email,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            Log::info('Request API send email requestOrder  :'  . $url);
            Log::info('Response API send email requestOrder  :'  . print_r($result->json(), true));
        }
        return true;
    }

    public static function sendRequestOrderCancel($data) {
        Log::info('Call API send email requestOrder :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('marketing.url.sendMailTrade');
        $subject = "[THÔNG BÁO] - Phiếu Yêu Cầu Ấn Phẩm Đã Bị Hủy";
        foreach ($data['user'] as $email) {
            $messageData = [
                "plan_name"             => $data['plan_name'],
                "url"                   => $data['url'],
                "subject"               => $subject,
            ];
            $dataPost = [
                "message"       =>  view("marketing::sendEmailRequestOrderCancel", $messageData)->render(),
                "toEmail"       => $email,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);

            Log::info('Request API send email requestOrder  :'  . $url);
            Log::info('Response API send email requestOrder  :'  . print_r($result->json(), true));
        }
        return true;
    }


    public static function sendRequestTransfer($data) {
        Log::info('Call API send email transfer :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('marketing.url.sendMailTrade');
        $subject = "[THÔNG BÁO] - Phiếu Điều Chuyển Ấn Phẩm Marketing";
        foreach ($data['user'] as $email) {
            $messageData = [
                "store_export"          => $data['store_export'],
                "store_import"          => $data['store_import'],
                "url"                   => $data['url'],
                "subject"               => $subject,
                "create"                => $data['create'] ?? "",
                "export"                => $data['export'] ?? "",
                "import"                => $data['import'] ?? "",
                "reason_cancel"         => $data['reason_cancel'] ?? "",
            ];
            $dataPost = [
                "message"       =>  view("marketing::sendEmailRequestTransfer", $messageData)->render(),
                "toEmail"       => $email,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            Log::info('Request API send email transfer  :'  . $url);
            Log::info('Response API send email transfer  :'  . print_r($result->json(), true));

        }
        return true;
    }
    
    public static function sendAdjustmentReport($data) {
        Log::info('Call API send email adjustmentReport :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('marketing.url.sendMailTrade');
        $type = $data['type'];
        $subject = "[THÔNG BÁO] - Phiếu điều chỉnh ấn phẩm tồn kho đã . ' ' . $type";
        foreach ($data['user'] as $email) {
            $messageData = [
                "type"                  => $type,
                "url"                   => $data['url'],
                "type"                  => $data['type'],
                "store_name"            => $data['store_name']
            ];
            $dataPost = [
                "message"       => view("marketing::sendEmailAdjustmentReport", $messageData)->render(),
                "toEmail"       => $email,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            Log::info('Request API send email adjustmentReport  :'  . $url);
            Log::info('Response API send email adjustmentReport  :'  . print_r($result->json(), true));
        }
        return true;
    }

    

    public static function sendExplanationReport($data) {
        Log::info('Call API send email explanationReport :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('marketing.url.sendMailTrade');
        $subject = "[THÔNG BÁO] - Giải trình báo cáo ấn phẩm tồn kho";
        foreach ($data['user'] as $email) {
            $messageData = [
                "url"                   => $data['url'],
                "store_name"            => $data['store_name']
            ];
            $dataPost = [
                "message"       => view("marketing::sendEmailExplanationReport", $messageData)->render(),
                "toEmail"       => $email,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            Log::info('Request API send email ExplanationReport  :'  . $url);
            Log::info('Response API send email ExplanationReport  :'  . print_r($result->json(), true));
        }
        return true;
    }

    public static function sendCreateReport($data) {
        Log::info('Call API send email report :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('marketing.url.sendMailTrade');
        $subject = "[THÔNG BÁO] - Báo cáo ấn phẩm tồn kho";
        foreach ($data['user'] as $email) {
            $messageData = [
                "url"                   => $data['url'],
                "store_name"            => $data['store_name']
            ];
            $dataPost = [
                "message"       => view("marketing::sendEmailReport", $messageData)->render(),
                "toEmail"       => $email,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            Log::info('Request API send email report  :'  . $url);
            Log::info('Response API send email report  :'  . print_r($result->json(), true));
        }
        return true;
    }

    public static function sendEmailPublication($data) {
        Log::info('Call API send email publication :'  . print_r($data, true));
        $url = env('MAILER_LOCAL') . '/'. config('marketing.url.sendMailTrade');
        if ($data['flag'] == "1") {
            $subject = "[THÔNG BÁO] - Ấn Phẩm Marketing Đã Được Đặt Hàng";
        }
        if ($data['flag'] == "2") {
            $subject = "[THÔNG BÁO] - Ấn Phẩm Marketing Đang Chờ Nghiệm Thu";
        }
        if ($data['flag'] == "3") {
            $subject = "[THÔNG BÁO] - Ấn Phẩm Marketing Đã Được Chỉnh Sửa";
        }
        if ($data['flag'] == "4") {
            $subject = "[THÔNG BÁO] - Ấn Phẩm Marketing Đã Được Nghiệm Thu";
        }
        if ($data['flag'] == "5") {
            $subject = "[THÔNG BÁO] - Ấn Phẩm Marketing Đã Được Phân Bổ";
        }
        if ($data['flag'] == "6") {
            $subject = "[THÔNG BÁO] - Ấn Phẩm Marketing Đã Được Nhập Kho";
        }
        foreach ($data['user'] as $email) {
            $messageData = [
                "url"                   => $data['url'],
                "publication"            => $data['publication'],
                "user"                  => $data['user'],
                'flag'                  => $data['flag'],
            ];
            $dataPost = [
                "message"       => view("marketing::sendEmailRequestPublication", $messageData)->render(),
                "toEmail"       => $email,
                "subject"       => $subject,
            ];
            $result = Http::asForm()->post($url, $dataPost);
            Log::info('Request API send email publication  :'  . $url);
            Log::info('Response API send email publication  :'  . print_r($result->json(), true));
        }
        return true;
    }

}
