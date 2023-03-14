<?php

namespace Modules\Mailer\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class BaseController extends Controller
{
    public $nameFrom = "IT-Support";
    public $emailFromKsnb = "VFC KSNB";
    public $tienngay    = "TienNgay.vn";
    public $emailTenancy = "VFC-KT";
    public $emailTrade = "Trade-Marketing";
    /**
     * @OA\Info(
     *     version="1.0",
     *     title="Mail"
     * )
     */
    public function __construct(

    ) {
        //
    }

    public static $errors = [
        200 => '200 OK',
        400 => '400 BAD REQUEST',
        401 => '401 UNAUTHORIZED',
        403 => '403 FORBIDDEN',
        404 => '404 NOT FOUND',
        405 => '405 METHOD NOT ALLOWED',
        413 => '413 PAYLOAD TOO LARGE',
        415 => '415 UNSUPPORTED MEDIA TYPE',
        415 => '415 TOO MANY REQUESTS',
        500 => '500 SERVER UNAVAILABLE',
        503 => '503 SERVICE NOT AVAILABLE'
    ];

    /**
    * Send email
    * @param String $emailFrom
    * @param String $emailTo
    * @param String $subject
    * @param String $message
    * @param String $nameFrom
    * @return boolean
    */
    public function sendMail($emailFrom, $emailTo, $subject, $message, $nameFrom, $chanel = 'mailer') {
        if (env('APP_ENV') != 'product') {
            // if server isn't product environment then system sents email just for white list email
            if (!in_array($emailTo, config('mailer.whitelist'))) {
                return [
                    'status' => true,
                    'message' => ''
                ];
            }
        }
        Log::channel($chanel)->info('SendEmail requested: ');
        Log::channel($chanel)->info('emailFrom: ' . $emailFrom);
        Log::channel($chanel)->info('emailTo: ' . $emailTo);
        Log::channel($chanel)->info('subject: ' . $subject);
        Log::channel($chanel)->info('message: ' . $message);
        Log::channel($chanel)->info('nameFrom: ' . $nameFrom);
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($emailFrom, $nameFrom);
        $email->setSubject($subject);
        $email->addTo($emailTo, '');
        $email->addContent('text/html', $message);
        $sendgrid = new \SendGrid(env('SENDGIRD_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            $statusCode = $response->statusCode();
            if ($statusCode == 202) {
                Log::channel($chanel)->info('Send email success' );
                return [
                    'status' => true,
                    'message' => ''
                ];
            } else {
                Log::channel($chanel)->info('Send email errors' );
                if (isset(self::$errors[$statusCode])) {
                    return [
                        'status' => false,
                        'message' => self::$errors[$statusCode]
                    ];
                } else {
                    return [
                        'status' => false,
                        'message' => 'undefined'
                    ];
                }
            }
        } catch (Exception $e) {
            Log::channel($chanel)->info('Exception Send email errors');
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }

    }
}
