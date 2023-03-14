<?php

namespace Modules\Mailer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Modules\MysqlCore\Entities\Mail;
use Modules\MysqlCore\Repositories\Interfaces\MailRepositoryInterface as MailRepository;
use Carbon\Carbon;
use Modules\MongodbCore\Repositories\Interfaces\UserCpanelRepositoryInterface as userCpanelRepository;
use Modules\MongodbCore\Repositories\Interfaces\EmailTemplateRepositoryInterface as emailTemplateRepository;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface as RoleRepository;
use Modules\MongodbCore\Entities\EmailTemplate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MailController extends BaseController
{

    /**
    * Modules\MysqlCore\Repositories\MailRepository
    */
    private $mailRepo;
    private $userCpanel;
    private $emailTemplateRepo;
    private $roleRepo;

    /**
     * @OA\Info(
     *     version="1.0",
     *     title="Mail"
     * )
     */
    public function __construct(
        MailRepository $mailRepository,
        userCpanelRepository $userCpanel,
        EmailTemplateRepository $emailTemplateRepo,
        RoleRepository $roleRepo
    ) {
        parent::__construct();
        $this->mailRepo = $mailRepository;
        $this->userCpanelRepo = $userCpanel;
        $this->emailTemplateRepo = $emailTemplateRepo;
        $this->roleRepo = $roleRepo;
    }

    /**
    * Send email alert server down
    * @param $emailFrom
    */
    public function sendMailAlertServerDown($message, $chanel = 'mailer', $user = 'all') {

        $mailsErrorIn30minutesAgo = $this->mailRepo->getMailByType(
            Mail::TYPE_ALERT_SERVER_DOWN,
            Carbon::now()->subMinutes(30),
            Carbon::now()
        );
        if ($mailsErrorIn30minutesAgo->count() > 0) {
            return false;
        }
        $stores = [
            Mail::FROM => "support@tienngay.vn",
            Mail::SUBJECT => "Cảnh Báo Server Không Có Phản Hồi",
            Mail::NAMEFROM => $this->nameFrom,
            Mail::TYPE => Mail::TYPE_ALERT_SERVER_DOWN,
            Mail::MESSAGE => $message
        ];
        if ($user == 'all') {
            $emailTo = explode(',', env('SEND_TO_EMAIL'));
            foreach($emailTo as $email) {
                $stores[Mail::TO] = $email;
                $this->mailRepo->store($stores);
            }
        } else {
            $stores[Mail::TO] = $user;
            $this->mailRepo->store($stores);
        }
    }

    /**
    * Send mail method
    * @param $emailFrom
    */
    public function sendWaitingMails($chanel = 'mailer') {

        $mails = $this->mailRepo->waitingSentMails();
        if($mails) {
            foreach($mails as $mail) {
                $result = $this->sendMail(
                    $mail[Mail::FROM],
                    $mail[Mail::TO],
                    $mail[Mail::SUBJECT],
                    $mail[Mail::MESSAGE],
                    $mail[Mail::NAMEFROM],
                    $chanel
                );
                if (isset($result['status']) && $result['status'] == true) {
                    $updateStatus = $this->mailRepo->updateStatus($mail[Mail::ID], Mail::STATUS_SUCCESS, 'success');
                } else {
                    $errorMessage = isset($result['message']) ? $result['message']: '';
                    $updateStatus = $this->mailRepo->updateStatus($mail[Mail::ID], Mail::STATUS_ERRORS, $errorMessage);
                }
            }
        }
    }

    /**
    * Push Queue Email
    * @param $emailFrom
    */
    public function queueEmail($subject, $message, $type, $toEmail) {

        $stores = [
            Mail::FROM => "support@tienngay.vn",
            Mail::SUBJECT => $subject,
            Mail::NAMEFROM => $this->nameFrom,
            Mail::MESSAGE => $message,
            Mail::TO => $toEmail,
            Mail::TYPE => $type
        ];

        $this->mailRepo->store($stores);
    }

    /**
    * Send Email Note, Report Ksnb
    * @param Illuminate\Http\Request;
    * @return Json;
    */
    public function sendEmailApi(Request $request) {
        $data = $request->all();
        $subject = $data['subject'];
        $message = $data['message'];
        $toEmail = $data['toEmail'];
        $stores = [
            Mail::FROM => "ksnb@tienngay.vn",
            Mail::SUBJECT => $subject,
            Mail::NAMEFROM => $this->emailFromKsnb,
            Mail::MESSAGE => $message,
            Mail::TO => $toEmail,
            Mail::TYPE => Mail::TYPE_KSNB,
        ];
        $mailer = $this->mailRepo->store($stores);
        return response()->json([
            'status' => true,
            'message' => 'success',
        ]);
    }

    /**
    * Tool Send Email
    * @param Illuminate\Http\Request;
    * @return Json;
    */
    public function toolSendEmail(Request $request) {
        $dataRequest = $request->all();
        log::info('API dataRequest:' . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            'subject' => 'required',
            'from' => 'required',
            'content' => 'required',
            'email' => 'required',
        ],
        [
            'subject.required'  => 'Tiêu đề email không được để trống',
            'from.required'     => 'Email gửi từ đâu không được để trống',
            'content.required'     => 'Nội dung email không được để trống',
            'email.required'     => 'Email người nhận không được để trống',
        ]);
        if($validator->fails()) {
            Log::info('saveEmail validator' .$validator->errors()->first());
            return response()->json([
                'message' => $validator->errors()->first()
            ]);
        }
        $full_name = $dataRequest['user_name'] ?? "Quý Khách Hàng";
        $nameFrom = !empty(config('mailer.nameFrom.marketing')) ? config('mailer.nameFrom.marketing') : config('mailer.nameFrom.cskh');
        $store = !empty($dataRequest['store']) ? $dataRequest['store'] : "";
        $code_name = !empty($dataRequest['content']) ? $dataRequest['content'] : "";
        $getMessage = $this->emailTemplateRepo->getMessageEmail($store, $code_name);
        $message = str_replace('{full_name}', '<strong>' . $full_name . '</strong >', $getMessage['message']);
        $input = [
            Mail::FROM => !empty($dataRequest['from']) ? $dataRequest['from'] : "",
            // Mail::FROM => "support@tienngay.vn",
            Mail::SUBJECT => !empty($dataRequest['subject']) ? $dataRequest['subject'] : "",
            Mail::NAMEFROM => $nameFrom,
            Mail::MESSAGE =>  $message,
            Mail::TO => !empty($dataRequest['email']) ? $dataRequest['email'] : "",
            Mail::TYPE => EmailTemplate::MKT,
        ];
        log::info('data input:'. print_r($input, true));
        $record =  $this->mailRepo->findRecord($dataRequest['email']);
       if (!$record) {
         $mailer = $this->mailRepo->store($input);
         log::info('record email saved:' . print_r($mailer, true));
        }
        return response()->json([
            'status' => true,
            'message' => 'success',
        ]);
    }

    /**
    * get code by store
    * @param Illuminate\Http\Request;
    * @return Json;
    */
    public function getCodeEmail(Request $request) {
        $dataRequest = $request->all();
        log::info('data input:' . print_r($dataRequest, true));
        $getCode = $this->emailTemplateRepo->getCodeEmail($dataRequest['code']);
        log::info('result get Code Email:' .print_r($getCode, true));
        if (!$getCode) {
            $response = [
                'status' => 400,
                'message'   => 'fails',
                'data'   => [],
            ];
        } else {
            $arrCode = [];
            foreach ($getCode as $item) {
                $arrCode[$item['code_name']] = $item['subject'];
            }
            $response = [
                'status' => 200,
                'message'   => 'success',
                'data'   => $arrCode,
            ];
        }
        return response()->json($response);
    }


    /**
    * save Template
    * @param Illuminate\Http\Request;
    * @return Json;
    */
    public function saveTemplate(Request $request) {
        $dataRequest = $request->all();
        Log::info('template save: ' . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            'subject' => 'required',
            'code' => 'required',
            'message' => 'required',
            'store' => 'required',
        ],
        [
            'subject.required'  => 'Tiêu đề email không được để trống',
            'code.required'     => 'Email gửi từ đâu không được để trống',
            'message.required'     => 'Nội dung email không được để trống',
            'store.required'     => 'Email người nhận không được để trống',
        ]);
        if($validator->fails()) {
            Log::info('saveEmail validator' .$validator->errors()->first());
            return response()->json([
                'message' => $validator->errors()->first()
            ]);
        }
        $store_name = $this->roleRepo->getNameById($dataRequest['store']);
        $input = [
            EmailTemplate::MESSAGE      => !empty($dataRequest['message']) ? $dataRequest['message'] : "",
            EmailTemplate::SUBJECT      => !empty($dataRequest['subject']) ? $dataRequest['subject'] : "",
            EmailTemplate::STORE        => !empty($dataRequest['store']) ? $dataRequest['store'] : "",
            EmailTemplate::CREATED_BY   => !empty($dataRequest['created_by']) ? $dataRequest['created_by'] : "",
            EmailTemplate::CODE         => !empty($dataRequest['code']) ? $dataRequest['code'] : "",
            EmailTemplate::STORE_NAME   => $store_name[0]['name'],
        ];
        Log::info('data input:' . print_r($input, true));
        $create = $this->emailTemplateRepo->saveTemplate($input);
        log::info('template saved:' . print_r($create, true));
        if (!$create) {
            $response = [
                'status' => 400,
                'message'   => "Tạo template thất bại",
                'data' => [],
            ];
        } else {
            $response = [
                'status' => 200,
                'message'   => "Tạo template thành công",
                'data' => $create,
            ];
        }
        return response()->json($response);
    }

        /**
    * get subject
    * @param Illuminate\Http\Request;
    * @return Json;
    */
    public function getSubject(Request $request) {
        $dataRequest = $request->all();
        log::info('data input:' . print_r($dataRequest, true));
        $getCode = $this->emailTemplateRepo->getSubject($dataRequest['code']);
        log::info('result get Code Email:' .print_r($getCode, true));
        if (!$getCode) {
            $response = [
                'status' => 400,
                'message'   => 'fails',
                'data'   => [],
            ];
        } else {
            $response = [
                'status' => 200,
                'message'   => 'success',
                'data'   => $getCode,
            ];
        }
        return response()->json($response);
    }


    /**
    * update Template
    * @param Illuminate\Http\Request;
    * @param String $id;
    * @return Json;
    */
    public function updateTemplate(Request $request, $id) {
        $dataRequest = $request->all();
        Log::info('template save: ' . print_r($dataRequest, true));
        $validator = Validator::make($dataRequest, [
            'subject' => 'required',
            'code' => 'required',
            'message' => 'required',
            'store' => 'required',
        ],
        [
            'subject.required'  => 'Tiêu đề email không được để trống',
            'code.required'     => 'Email gửi từ đâu không được để trống',
            'message.required'     => 'Nội dung email không được để trống',
            'store.required'     => 'Email người nhận không được để trống',
        ]);
        if($validator->fails()) {
            Log::info('saveEmail validator' .$validator->errors()->first());
            return response()->json([
                'message' => $validator->errors()->first()
            ]);
        }
        $store_name = $this->roleRepo->getNameById($dataRequest['store']);
        $input = [
            EmailTemplate::MESSAGE      => !empty($dataRequest['message']) ? $dataRequest['message'] : "",
            EmailTemplate::SUBJECT      => !empty($dataRequest['subject']) ? $dataRequest['subject'] : "",
            EmailTemplate::STORE        => !empty($dataRequest['store']) ? $dataRequest['store'] : "",
            EmailTemplate::UPDATED_BY   => !empty($dataRequest['updated_by']) ? $dataRequest['updated_by'] : "",
            EmailTemplate::CODE         => !empty($dataRequest['code']) ? $dataRequest['code'] : "",
            EmailTemplate::STORE_NAME   => $store_name[0]['name'],
        ];
        Log::info('data input:' . print_r($input, true));
        $update = $this->emailTemplateRepo->updateTemplate($input, $id);
        log::info('template updated:' . print_r($update, true));
        if (!$update) {
            $response = [
                'status' => 400,
                'message'   => "Cập nhật template thất bại",
                'data' => [],
            ];
        } else {
            $response = [
                'status' => 200,
                'message'   => "Cập nhật template thành công",
                'data' => $update,
            ];
        }
        return response()->json($response);
    }

    public function getUserMkt() {
        $emails = $this->roleRepo->getUserMkt();
        $response = [
            'status'    => 200,
            'message'   => 'thành công',
            'data'      => $emails,
        ];
        return response()->json($response);
    }


    /**
    * get slug
    * @param Illuminate\Http\Request;
    * @return Json;
    */
    public function getSlug(Request $request) {
        $dataRequest = $request->all();
        log::info('data input:' . print_r($dataRequest, true));
        $getCode = $this->emailTemplateRepo->getSlug($dataRequest['code']);
        log::info('result:' .print_r($getCode, true));
        if (!$getCode) {
            $response = [
                'status' => 400,
                'message'   => 'fails',
                'data'   => [],
            ];
        } else {
            $response = [
                'status' => 200,
                'message'   => 'success',
                'data'   => $getCode['slug'],
            ];
        }
        return response()->json($response);
    }


    /**
    * send email check password
    * @param Illuminate\Http\Request;
    * @return Json;
    */
    public function sendEmailCheckPass(Request $request) {
        $data = $request->all();
        $subject = $data['subject'];
        $toEmail = $data['toEmail'];
        $nameFrom = $data['nameFrom'];
        $type = $data['type'];
        $messageData = [
            'name' => $data['name'],
            'email' => $data['toEmail'],
            'url' => $data['url'],
        ];
        $message = view("mailer::sendEmailCheckPass", $messageData);
        $stores = [
            Mail::FROM => "support@tienngay.vn",
            Mail::SUBJECT => $subject,
            Mail::NAMEFROM => $nameFrom,
            Mail::MESSAGE => $message,
            Mail::TO => $toEmail,
            Mail::TYPE => $type
        ];
        $mailer = $this->mailRepo->store($stores);
        return response()->json([
            'status' => true,
            'message' => 'success',
        ]);
    }

//api mail trade_mkt
    public function sendMailTenancy(Request $request)
    {
        $data = $request->all();
        $subject = $data['subject'];
        $message = $data['message'];
        $toEmail = $data['toEmail'];
        $stores = [
            Mail::FROM => "support@tienngay.vn",
            Mail::SUBJECT => $subject,
            Mail::NAMEFROM => $this->emailTenancy,
            Mail::MESSAGE => $message,
            Mail::TO => $toEmail,
            Mail::TYPE => Mail::TYPE_TENANCY,
        ];
        $mailer = $this->mailRepo->store($stores);
        return response()->json([
            'status' => true,
            'message' => 'success',
        ]);

    }

//api mail trade_mkt
    public function sendMailTrade(Request $request)
    {
        $data = $request->all();
        $subject = $data['subject'];
        $message = $data['message'];
        $toEmail = $data['toEmail'];
        $stores = [
            Mail::FROM => "support@tienngay.vn",
            Mail::SUBJECT => $subject,
            Mail::NAMEFROM => $this->emailTrade,
            Mail::MESSAGE => $message,
            Mail::TO => $toEmail,
            Mail::TYPE => Mail::TYPE_TRADE,
        ];
        $mailer = $this->mailRepo->store($stores);
        return response()->json([
            'status' => true,
            'message' => 'success',
        ]);

    }
}
