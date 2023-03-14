<?php


namespace Modules\Tenancy\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Entities\PaymentPeriod;
use Modules\MongodbCore\Entities\Tenancy;
use Modules\MongodbCore\Repositories\PaymentPeriodRepository;
use Modules\MongodbCore\Repositories\TenancyRepository;
use Modules\Tenancy\Service\tenancyApi;
use Modules\MysqlCore\Entities\Mail;
use Modules\MysqlCore\Repositories\Interfaces\MailRepositoryInterface as MailRepository;


class PaymentPeriodController extends BaseController
{
    private $PaymentPeriodRepository;
   private $tenancyRepository;
   private $mailRepository;

    public function __construct(PaymentPeriodRepository $PaymentPeriodRepository,
                                TenancyRepository $tenancyRepository,
                                 MailRepository $mailRepository
                                )
    {
        $this->PaymentPeriodRepository = $PaymentPeriodRepository;
        $this->tenancyRepository = $tenancyRepository;
        $this->mailRepository = $mailRepository;
    }

    public function createData(Request $request)
    {
        $inputData = $request->all();
        $validate = Validator::make((array)$inputData, [
            // "code_contract" => "required|string|unique:mongodb.tenancy,contract",
        ]);
        if ($validate->fails()) {
            return false;
        }
        $result_tenancy = $this->tenancyRepository->findData();
        if (!empty($result_tenancy)){
            foreach ($result_tenancy as $item){
                $code_contract = $item["code_contract"];
                $date_contract = $item["date_contract"];
                $contract_expiry_date = $item["contract_expiry_date"];
                $start_date_contract = $item["start_date_contract"];
                $end_date_contract = $item["end_date_contract"];
                $one_month_rent = $item["one_month_rent"];
                $ky_tra = $item["ky_tra"];
                $customer_infor = $item['customer_infor'];
                $ten_chu_nha = $item["customer_infor"]["ten_chu_nha"];
                $sdt_chu_nha = $item["customer_infor"]["sdt_chu_nha"];
            }
            $resultTenancy = $this->PaymentPeriodRepository->findData($code_contract,$ky_tra);
            if (empty($resultTenancy)){
                $result_payment = $this->PaymentPeriodRepository->insertData($request);
            }
        }
        return BaseController::sendResponse(BaseController::HTTP_OK, "find success", $result_payment);
    }
//thanh toan từng kỳ (thanh toán bình thường, thanh toán cấn trừ cọc)
    public function payment_Tenancy(Request $request, $id)
    {
        try {
            $inputData = $request->all();
             $validate = Validator::make($inputData, [
                'ngay_thanh_toan_tt' => 'required'
             ],
             [
                'ngay_thanh_toan_tt.required' => 'Ngày thanh toán thực tế không được để trống'
             ]);
             if ($validate->fails()) {
                log::channel('Tenancy')->info('Validate error ' . $validate->errors());
                return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST,$validate->errors()->first());
             }
            $result_period =  $this->PaymentPeriodRepository->findOnePaymentPeriod($request->_id);
            $data = [
                PaymentPeriod::COLUMN_ID => $request->_id,
                PaymentPeriod::COLUMN_CODE_CONTRACT => !empty($request->code_contract) ?? null,
                PaymentPeriod::COLUMN_ONE_MONTH_RENT => $request->one_month_rent,
                Tenancy::COLUMN_TIEN_COC => $request->tien_coc ?? 0,
                Tenancy::COLUMN_CREATED_BY =>$request->user->email,
                PaymentPeriod::COLUMN_NGAY_THANH_TOAN_TT => $request->ngay_thanh_toan_tt
            ];
            $resultPayment = $this->PaymentPeriodRepository->paymentTenancy($data);
            $action = "thanh toán có cấn cọc thành công";
            $action1 = "thanh toán  thành công";
            $action2 = "thanh toán không thành công";

            if (empty($request->one_month_rent) && empty($resultPayment->tien_coc)) {
                $this->tenancyRepository->log($id, $action2, $request->user->email);
                return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "Số tiền thanh toán chưa chính xác", []);
            }

            if (($resultPayment && !empty($request->tien_coc)) && (($result_period['one_month_rent']) ==
                $request->tien_coc + $request->one_month_rent)
            ) {
                $this->tenancyRepository->log($id, $action, $request->user->email);
                return BaseController::sendResponse(BaseController::HTTP_OK, "payment success", $resultPayment);
            }elseif($resultPayment && empty($request->tien_coc)
                && (($result_period['one_month_rent']) == $request->one_month_rent)
            ){
                $this->tenancyRepository->log($id, $action1, $request->user->email);
                return BaseController::sendResponse(BaseController::HTTP_OK, "payment success", $resultPayment);
            }else{
                $this->tenancyRepository->log($id, $action2, $request->user->email);
                return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "Số tiền thanh toán chưa chính xác",[]);
            }

        } catch (\Exception $e) {
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

//thanh toán tiền thuế
    public function thanh_toan_thue(Request $request,$id)
    {
        $inputData = $request->all();
        $action = "thanh toán thuế thành công";
        $action1 = "thanh toán thuế thất bại";
        $validate = Validator::make($inputData, [
            'ngay_thanh_toan_thue' => "required|string",
            'image_thue' => "required",
        ],
        [
            'ngay_thanh_toan_thue.required' => 'Ngày thanh toán thuế không được bỏ trống',
        ]);

        if ($validate->fails()) {
            log::channel('Tenancy')->info('Thanh toán thuế thất bại ' . $validate->errors());
            $this->tenancyRepository->log($id, $action1, $request->user->email);
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, $validate->errors());
        }
        $data = [
            PaymentPeriod::COLUMN_ID => $request->_id,
            PaymentPeriod::COLUMN_CODE_CONTRACT => !empty($request->code_contract) ?? null,
            PaymentPeriod::COLUMN_TIEN_THUE => $request->tien_thue,
            PaymentPeriod::COLUMN_NGAY_THANH_TOAN_THUE => $request->ngay_thanh_toan_thue,
            PaymentPeriod::COLUMN_IMAGE_THUE => $request->image_thue,
        ];
        $result = $this->PaymentPeriodRepository->ThanhToanThue($data);
        if (!empty($result) && $result == true){
            $this->tenancyRepository->log($id,$action,$request->created_by);
            return BaseController::sendResponse(BaseController::HTTP_OK, "payment success",$result);
        }elseif( $result == false){
            $this->tenancyRepository->log($id,$action1,$request->created_by);
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "payment error",$result);
        }

    }

// các bản ghi tới hạn
    public function toi_han(Request $request)
    {
        $result = $this->PaymentPeriodRepository->findDataToiHan($request);
        return BaseController::sendResponse(BaseController::HTTP_OK, " thanh cong", $result);
    }

// các bản ghi quá hạn
    public function qua_han(Request $request)
    {
        $result = $this->PaymentPeriodRepository->findDataQuaHan($request);
        return BaseController::sendResponse(BaseController::HTTP_OK, " thanh cong", $result);
    }

//cập nhật số tiền cọc của mặt bằng
    public function updateTienCocChuNha(Request $request, $id)
    {
        $resultTenancyTienCoc = $this->tenancyRepository->findOne($id);
        $tienCocConLai = $resultTenancyTienCoc['tien_coc_thua'];
        if (!empty($resultTenancyTienCoc) && $tienCocConLai > "0") {
            if (!empty($request->coc_bctt && $request->coc_bctt <= $tienCocConLai) && !empty($request->ngay_thanh_toan_coc)) {
                $result = $this->PaymentPeriodRepository->updateTienCocChuNha($request, $id);
                return BaseController::sendResponse(BaseController::HTTP_OK, "Thành công", $result);
            } elseif (empty($request->coc_bctt) || empty($request->ngay_thanh_toan_coc)) {
                return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "Thất bại");
            }
        }
    }

//ghi chú từng bản ghi
    public function note_tenancy(Request $request)
    {
        $inputData = $request->all();
        $validate = Validator::make($inputData, [
            'note' => "required|string",
            'note_description' => "required|string"
        ],
            [
                'note.required' => "Tiêu đề ko được để trống",
                'note_description.required' => "Nội dung ko được để trống",
            ]
        );
         if ($validate->fails()) {
             log::channel('Tenancy')->info('Validate note error ' . $validate->errors());
             return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, $validate->errors());
         }
        $result = $this->PaymentPeriodRepository->noteTenancy($request);
        return BaseController::sendResponse(BaseController::HTTP_OK, " thanh cong", $result);
    }

 //tìm từng bản ghi của từng kỳ
    public function find_one_payment_priod($id)
    {
        $result = $this->PaymentPeriodRepository->findOnePaymentPeriod($id);
        return BaseController::sendResponse(BaseController::HTTP_OK, " thanh cong", $result);
    }

//gửi mail bản ghi tới hạn
    public function send_mail_toi_han()
    {
        $result = $this->PaymentPeriodRepository->sendMailToiHan();
        if ($result){
            tenancyApi::send_email_tenancy($result);
             return BaseController::sendResponse(BaseController::HTTP_OK, " thành công", $result);
        }else{
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, " thất bại", $result);
        }
    }

//gửi mail bản ghi quá hạn
    public function send_mail_qua_han(Request $request)
    {
        $result = $this->PaymentPeriodRepository->findDataQuaHan($request);
        if ($result) {
            tenancyApi::sendEmailTenancy($result);
            return BaseController::sendResponse(BaseController::HTTP_OK, " thành công", $result);
        }else{
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, " thất bại", $result);
        }
    }

//tim chứng từ của từng kỳ thanh toán
    public function findImageKyHan(Request $request)
    {
        $result = $this->PaymentPeriodRepository->find_image_ky_han($request);
        return BaseController::sendResponse(BaseController::HTTP_OK, " thành công", $result);
    }


//Cập nhật số tiền thanh toán phải trả và số tiền thanh toán thực tế đã trả
    public function updateMoney(Request $request)
    {
        $result_tong_tien_thanh_toan = $this->PaymentPeriodRepository->find_sum_money_1($request);
        $result_tong_tien_da_tra = $this->PaymentPeriodRepository->find_sum_money_2($request);
        return BaseController::sendResponse(BaseController::HTTP_OK, " thành công", ['data' => $result_tong_tien_thanh_toan ,'data1'=>$result_tong_tien_da_tra]);
    }

//Cập nhật số tiền thuế thanh toán phải trả và số tiền thuế thanh toán thực tế đã trả
    public function updateMoneyPax(Request $request)
    {
        $result_tong_tien_thue = $this->PaymentPeriodRepository->find_sum_money_pax($request);
        $result1_tong_tien_thue_da_tra = $this->PaymentPeriodRepository->find_sum_money_pax1($request);
        return BaseController::sendResponse(BaseController::HTTP_OK, " thành công", ['data' => $result_tong_tien_thue ,'data1'=>$result1_tong_tien_thue_da_tra]);
    }


//update kỳ trả của từng hợp đồng

    public function update_payment_ky_han(Request $request,$id)
    {
        try {
           $result = $this->PaymentPeriodRepository->updatePaymentKyHan($request,$id);
            return BaseController::sendResponse(BaseController::HTTP_OK, " thành công", $result);
        }catch (\Exception $e){
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    public function find_one_payment_priod_ky_han(Request $request)
    {
        $result = $this->PaymentPeriodRepository->findOnePaymentPeriodKyHan($request);
        return BaseController::sendResponse(BaseController::HTTP_OK, " thanh cong", $result);
    }

    //test
    public function test(Request $request,$id)
    {
        try {
           $result = $this->PaymentPeriodRepository->updatePaymentKyHan($request,$id);
            return BaseController::sendResponse(BaseController::HTTP_OK, " thành công", $result);
        }catch (\Exception $e){
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

}
