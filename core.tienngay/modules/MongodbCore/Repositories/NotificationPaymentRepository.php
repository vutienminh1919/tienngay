<?php


namespace Modules\MongodbCore\Repositories;

use Carbon\Carbon;
use Mockery\Matcher\Not;
use Modules\MongodbCore\Entities\NotificationPayment;
use Modules\MongodbCore\Entities\PaymentPeriod;
use Modules\MongodbCore\Entities\Tenancy;

class NotificationPaymentRepository
{
        protected $notificationPaymentModel;
        protected $paymentPeriodModel;
        protected $tenancyModel;
        protected $paymentPeriodRepository;

        public function __construct(NotificationPayment $notificationPayment,
                                    PaymentPeriod $paymentPeriod,Tenancy $tenancyModel,PaymentPeriodRepository $paymentPeriodRepository)
        {
            $this->paymentPeriodModel = $paymentPeriod;
            $this->notificationPaymentModel = $notificationPayment;
            $this->tenancyModel = $tenancyModel;
            $this->paymentPeriodRepository = $paymentPeriodRepository;

        }

//thêm thông báo ngày thanh toán thực tế bị thay đổi so với ngày thanh toán gốc
    public function insertNotification($request)
    {
    $bool = false;
    $resultPayment = $this->paymentPeriodModel
                ->where([PaymentPeriod::COLUMN_CODE_CONTRACT => $request->code_contract])
                ->where([PaymentPeriod::COLUMN_NGAY_THANH_TOAN => $request->ngay_thanh_toan])
                ->first()->toArray();
     $hop_dong_so = $resultPayment['hop_dong_so'];
     $oneMonthRent = $resultPayment['one_month_rent'];
     $code_contract = $resultPayment['code_contract'];
     $ngayThanhToan = $resultPayment['ngay_thanh_toan'];
        $data = [
            NotificationPayment::COLUMN_CODE_CONTRACT => $request->code_contract ?? null,
            NotificationPayment::COLUMN_HOP_DONG_SO => $hop_dong_so,
            NotificationPayment::COLUMN_ONE_MONTH_RENT => $oneMonthRent,
            NotificationPayment::COLUMN_NGAY_THANH_TOAN => $request->ngay_thanh_toan ?? null,
            NotificationPayment::COLUMN_NGAY_THANH_TOAN_TT => strtotime($request->ngay_thanh_toan_tt) ?? null,
            NotificationPayment::COLUMN_CREATED_AT => time(),
            NotificationPayment::COLUMN_CREATED_BY => $request->created_by,
            NotificationPayment::COLUMN_STATUS => NotificationPayment::COLUMN_BLOCK,
            NotificationPayment::COLUMN_STATUS_NOTIFICATION => NotificationPayment::COLUMN_BLOCK
        ];
        $resultTenancy = $this->notificationPaymentModel
        ->where([NotificationPayment::COLUMN_NGAY_THANH_TOAN => $ngayThanhToan,
                NotificationPayment::COLUMN_CODE_CONTRACT => $code_contract,
        ])->first();

        if (empty($resultTenancy) && $this->notificationPaymentModel->create($data)){
            $bool = true;
        }else{
            $bool = false;
        }
        return $bool;
    }

//gửi thông báo đến người thanh toán và cập nhật lại bản ghi

    public function sendNotification()
    {
        $curentTime = time();
        $curentDay = strtotime(trim(date('Y/m/d',$curentTime) . ' 00:00:00'));
        $result = $this->notificationPaymentModel
        ->where((NotificationPayment::COLUMN_NGAY_THANH_TOAN_TT), '<',$curentDay)
        ->Where(NotificationPayment::COLUMN_STATUS,NotificationPayment::COLUMN_BLOCK)
        ->get()->toArray();
        $arrData = [];
        foreach ($result as $value){
            $code_contract  = $value['code_contract'];
            $ngay_thanh_toan = $value['ngay_thanh_toan'];
            $resultPayment = $this->paymentPeriodModel
            ->where([
                PaymentPeriod::COLUMN_CODE_CONTRACT => $code_contract,
                PaymentPeriod::COLUMN_NGAY_THANH_TOAN => $ngay_thanh_toan
            ])->first()->toArray();
            $status = $resultPayment['status'];
            $statusThue = $resultPayment['status_thue'];
            if ($resultPayment['status'] == 'chua_thanh_toan'){
                 $resultNotification = $this->notificationPaymentModel
                 ->where([
                      NotificationPayment::COLUMN_CODE_CONTRACT => $code_contract,
                      NotificationPayment::COLUMN_NGAY_THANH_TOAN => $ngay_thanh_toan
                 ])->first();
                 if ($resultNotification){
                    $arrData[] = $resultNotification;
                 }
            }else{
                $resultNotification2 = $this->notificationPaymentModel
                ->where([
                    NotificationPayment::COLUMN_CODE_CONTRACT => $code_contract,
                    NotificationPayment::COLUMN_NGAY_THANH_TOAN => $ngay_thanh_toan
                ])->update([NotificationPayment::COLUMN_STATUS => NotificationPayment::COLUMN_ACTIVE]);
            }
        }
        return $arrData;
    }

//lấy tất cả các bản ghi

    public function getAll()
    {
        $result = $this->notificationPaymentModel->get();

        return $result;
    }

//update status notification

    public function status_notification($id)
    {
        $result = $this->notificationPaymentModel->where([NotificationPayment::COLUMN_ID => $id])->find($id)->toArray();
        if ($result['status_notification'] == NotificationPayment::COLUMN_ACTIVE) {
            $this->notificationPaymentModel->where([NotificationPayment::COLUMN_ID => $id])->update([NotificationPayment::COLUMN_STATUS_NOTIFICATION => NotificationPayment::COLUMN_BLOCK]);
        } else {
            $this->notificationPaymentModel->where([NotificationPayment::COLUMN_ID => $id])->update([NotificationPayment::COLUMN_STATUS_NOTIFICATION => NotificationPayment::COLUMN_ACTIVE]);
        }
        return $result;
    }

//lấy tất cả kỳ trả hợp đồng đang cho thuê

    public function contractActive($request)
    {
        $result = $this->tenancyModel
        ->where(
        [
         Tenancy::COLUMN_CODE_CONTRACT => $request->code_contract,
         Tenancy::COLUMN_STATUS => Tenancy::COLUMN_ACTIVE
        ])->first()->toArray();
        if (!empty($result)){
           $payment = $this->paymentPeriodRepository->getAllSameCodeContract($request->code_contract);
        }
        return $payment;
    }

//lấy tất cả hợp đồng đang cho thuê
    public function getAllTenancy()
    {
        $result = $this->tenancyModel->where([Tenancy::COLUMN_STATUS => Tenancy::COLUMN_ACTIVE])->get()->toArray();
        return $result;
    }

}
