<?php


namespace Modules\Tenancy\Http\Controllers;


use Modules\MongodbCore\Repositories\NotificationPaymentRepository;
use Illuminate\Http\Request;
use Modules\MongodbCore\Repositories\PaymentPeriodRepository;
use Modules\Tenancy\Service\tenancyApi;
use Modules\MysqlCore\Entities\Mail;
use Modules\MysqlCore\Repositories\Interfaces\MailRepositoryInterface as MailRepository;

class NotificationPaymentController extends BaseController
{
     private $PaymentPeriodRepository;
     private $NotificationPaymentRepository;
     private $mailRepository;

    public function __construct(PaymentPeriodRepository $PaymentPeriodRepository,
                                NotificationPaymentRepository $NotificationPaymentRepository,
                                MailRepository $mailRepository)
    {
        $this->PaymentPeriodRepository = $PaymentPeriodRepository;
        $this->NotificationPaymentRepository = $NotificationPaymentRepository;
        $this->mailRepository = $mailRepository;

    }


    public function createData(Request $request)
    {
        $result = $this->NotificationPaymentRepository->insertNotification($request);
        if (!empty($result) && $result == true) {
            return BaseController::sendResponse(BaseController::HTTP_OK, "insert success", $result);
        } elseif ($result == false) {
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "insert error", $result);
        }
    }

//gửi mail thông báo đến người thanh toán và cập nhật lại bản ghi
    public function send_notification_email()
    {
        $result = $this->NotificationPaymentRepository->sendNotification();
        if ($result){
             $a =  tenancyApi::send_email_notification($result);
            return BaseController::sendResponse(BaseController::HTTP_OK, " thành công", ['data'=>$result ,'data1' => $a]);
        }else{
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, " thất bại", $result);
        }
    }

//lấy tất cả các bản ghi

    public function getDataAll()
    {
        $result = $this->NotificationPaymentRepository->getAll();
        return BaseController::sendResponse(BaseController::HTTP_OK, "insert success", $result);
    }

//thông báo đến người thanh toán và cập nhật lại bản ghi
    public function send_notification()
    {
        $result = $this->NotificationPaymentRepository->sendNotification();
        if ($result){
            return BaseController::sendResponse(BaseController::HTTP_OK, " thành công", $result);
        }else{
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, " thất bại", $result);
        }
    }

//update trạng thái thông báo

    public function statusNotification($id)
    {
       $result = $this->NotificationPaymentRepository->status_notification($id);
       return BaseController::sendResponse(BaseController::HTTP_OK, "update success", $result);
    }

//lấy tất cả kỳ trả hợp đồng đang cho thuê

    public function contract_active(Request $request)
    {
         $result = $this->NotificationPaymentRepository->contractActive($request);
         return BaseController::sendResponse(BaseController::HTTP_OK, "find success", $result);
    }


    public function get_all_tenancy()
    {
         $result = $this->NotificationPaymentRepository->getAllTenancy();
         return BaseController::sendResponse(BaseController::HTTP_OK, "find success", $result);
    }




    public function test( )
    {
        $result = $this->NotificationPaymentRepository->getAllTenancy();
        return BaseController::sendResponse(BaseController::HTTP_OK, "insert success", $result);
    }



}
