<?php


namespace Modules\Tenancy\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\MongodbCore\Entities\PaymentPeriod;
use Modules\MongodbCore\Entities\Tenancy;
use Modules\MongodbCore\Repositories\PaymentPeriodRepository;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\MongodbCore\Repositories\TenancyRepository;
use Modules\MongodbCore\Entities\District;
use DateTime;
use Carbon\Carbon;
use mysql_xdevapi\Exception;

class TenancyController extends BaseController
{
    private $tenancyRepository;
    private $PaymentPeriodRepository;
    private $roleRepository;

    public function __construct(TenancyRepository $tenancyRepository,
                                PaymentPeriodRepository $PaymentPeriodRepository,
                                RoleRepository $roleRepository)
    {
        $this->tenancyRepository = $tenancyRepository;
        $this->PaymentPeriodRepository = $PaymentPeriodRepository;
        $this->roleRepository = $roleRepository;
    }

    public function create_tenancy(Request $request)
    {
        $inputData = $request->all();
        $userPtmb = $this->findUserPtmb();
        $validate = Validator::make($inputData, [
            "code_contract" => "required|string|unique:mongodb.tenancy,code_contract",
            "date_contract" => "required",
            "contract_expiry_date" => "required",
            "start_date_contract" => "required|date_format:Y-m-d",
            "end_date_contract" => "required|date_format:Y-m-d|after:start_date_contract",
            "address" => "required|string",
            "name_cty" => "required|string",
            "one_month_rent" => "required",
            "ky_tra" => "required",
            "ten_chu_nha" => "required|string",
            //"sdt_chu_nha" => "required|numeric|regex:/^[0-9]+$/",
            "sdt_chu_nha" => "numeric|regex:/^[0-9]+$/",
            "ten_tk_chu_nha" => "required|string",
            "so_tk_chu_nha" => "required|regex:/^[0-9]+$/|max:30|min:1",
            "bank_name" => "required|string",
            //"tien_coc" => "required",
            //"ngay_dat_coc" => "required",
            //'dien_tich' => "required|string",
            'store_name' => "required|string",
        ], [
            'code_contract.required' => "Số hợp đồng ko để trống",
            'code_contract.unique' => "Số hợp đồng đã tồn tại",
            'date_contract.required' => "Ngày ký hợp đồng không được để trống",
            'contract_expiry_date.required' => 'Thời hạn thuê không được để trống',
            'start_date_contract.required' => 'Ngày bắt đầu hợp đồng không được để trống',
            'start_date_contract.date_format' => 'Ngày bắt đầu hợp đồng không đúng định dạng,vd: YYYY-mm-dd',
            'end_date_contract.required' => 'Ngày kết thúc hợp đồng không được để trống',
            'end_date_contract.date_format' => 'Ngày kết thúc hợp đồng không đúng định dạng,vd: YYYY-mm-dd',
            'address.required' => 'Khu vực không được để trống',
            'name_cty.required' => 'Tên công ty hoặc chi nhánh không được để trống',
            'one_month_rent.required' => 'Giá thuê/tháng không được để trống',
            'ten_chu_nha.required' => 'Họ và tên(chủ nhà) không được để trống',
            //'sdt_chu_nha.required' => 'Số điện thoại chủ nhà không được để trống',
            'ten_tk_chu_nha.required' => 'Tên chủ tài khoản không được để trống',
            'so_tk_chu_nha.required' => 'Số tài khoản nhận thanh toán không được để trống',
            'bank_name.required' => 'Ngân hàng không được để trống',
            //'tien_coc.required' => 'Số tiền đặt cọc không được để trống',
            //'ngay_dat_coc.required' => 'Ngày đặt cọc không được để trống',
            //'dien_tich.required' => 'Diện tích không được để trống',
            'store_name.required' => 'Tên phòng giao dịch không được để trống',
            'ky_tra.required' => 'Kỳ trả không được để trống',
            'end_date_contract.after' => 'Ngày kết thúc hợp đồng không được nhỏ hơn ngày bắt đầu hợp đồng',
            'so_tk_chu_nha.regex' => 'Số tài khoản không được có ký tự đặc biệt và chữ vd:(- , _, abc , ...)',
            'so_tk_chu_nha.max' => 'Số tài khoản không được vượt quá 30 số',
            'so_tk_chu_nha.min' => 'Số tài khoản không được vượt quá 1 số',
            'sdt_chu_nha.regex' => 'Số điện thoại chủ nhà không được có ký tự đặc biệt vd:(- , _ ,...)',
            'sdt_chu_nha.numeric' => 'Số điện thoại không được nhập chữ',
        ]);
        if ($validate->fails()) {
            log::channel('Tenancy')->info('validate error ' . $validate->errors());
            if (!empty($request->typeMsg) && $request->typeMsg == 'all') {
                $message = $validate->errors();
            } else {
                $message = $validate->errors()->first();
            }
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, $message);
        }


        $result = $this->tenancyRepository->createTenancy($request);
        if (!empty($result)) {
            $start = $result->start_date_contract;
            $end = $result->end_date_contract;
            $kyTra = $result->ky_tra;
            $id = $result->_id;
            $contract_expiry_date = $result->contract_expiry_date;
            $hopDongSo = $result->hop_dong_so;
            $createdAt = $result->created_at;
            $one_month_rent = $result->one_month_rent;
            $data2 = [
                'start_date_contract' => $start,
                'end_date_contract' => $end,
                'ky_tra' => $kyTra,
                'contract_expiry_date' => $contract_expiry_date,
                'hop_dong_so' => $hopDongSo,
                'created_at' => $createdAt,
                'one_month_rent' => $one_month_rent,
            ];
            $result1 = $this->tenancyRepository->updateTenancyKyTraTenancy($request, $id);
            log::channel('Tenancy')->info('Thêm kỳ hạn thành công ' . ($result));
        }
        return BaseController::sendResponse(BaseController::HTTP_OK, "insert success", $result);
    }

//cập nhật  lại hợp đồng
    public function update_tenancy(Request $request, $id)
    {
        $inputData = $request->all();
        $userPtmb = $this->findUserPtmb();
//        $validate = Validator::make($inputData, [
//
//        ],[
//
//        ]);
//        if ($validate->fails()) {
//            $action1 = "Cập nhật hợp đồng thất bại";
//            log::channel('Tenancy')->info('Validate error ' . $validate->errors());
//            $this->tenancyRepository->log($id, $action1, $request->user->email);
//            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "update tenancy error", $validate->errors());
//        }
        $data = [
            Tenancy::COLUMN_STAFF_PTMB => !empty($inputData['staff_ptmb']) ? $inputData['staff_ptmb'] : "",
            Tenancy::COLUMN_NGUOI_NOP_THUE => !empty($inputData['nguoi_nop_thue']) ? $inputData['nguoi_nop_thue'] : "",
            Tenancy::COLUMN_MA_SO_THUE => !empty($inputData['ma_so_thue']) ? $inputData['ma_so_thue']: "",
            Tenancy::COLUMN_UPDATED_BY => $request->user->email,
        ];
        $tenancy = $this->tenancyRepository->findOne($id);
        if (!empty($tenancy) && ($tenancy['status'] == 'active')) {
           $result = $this->tenancyRepository->updateTenancy($data, $id);
           $action = "Cập nhật hợp đồng thành công";
           $this->tenancyRepository->log($id, $action, $request->user->email);
           return BaseController::sendResponse(BaseController::HTTP_OK, "update success", $result);
        }else{
            $action1 = "Cập nhật hợp đồng không thành công";
            $this->tenancyRepository->log($id, $action1, $request->user->email);
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "update failed");
        }
    }

// thêm kỳ hạn mới
    public function newInsertKyHan(Request $request, $id)
    {
        $action = "Thêm phụ lục thành công";
        $action1 = "Thêm phụ lục thất bại";
        $inputData = $request->all();
        $validate = Validator::make($inputData, [
            'start_date_contract' => "required|date",
            'end_date_contract' => "required|date|after:start_date_contract",
            'ky_tra' => "required|string",
            'contract_expiry_date' => "required|string",
            'one_month_rent' => "required|string",
        ],
            [
                'start_date_contract.required' => 'Ngày bắt đầu hợp đồng không được để trống',
                'end_date_contract.required' => 'Ngày kết thúc hợp đồng không được để trống',
                'ky_tra.required' => 'Kỳ hạn thanh toán không được để trống',
                'contract_expiry_date.required' => 'Thời hạn thuê không được để trống',
                'one_month_rent.required' => 'Giá thuê không được để trống',
                'end_date_contract.after' => 'Ngày kết thúc hợp đồng không được nhỏ hơn ngày bắt đầu hợp đồng',
            ]
        );
        if ($validate->fails()) {
            log::channel('Tenancy')->info('Thêm mới kỳ hạn thất bại ' . $validate->errors());
            $this->tenancyRepository->log($id, $action1, $request->user->email);
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, $validate->errors());
        }
        $findKyHan = $this->tenancyRepository->findOne($id);
        $countKyHan = count($findKyHan['ky_han']);
        $timeKyHan = $this->findLatsEnddate($id);
        $data = [
            Tenancy::COLUMN_START_DATE_CONTRACT =>strtotime($request->start_date_contract),
            Tenancy::COLUMN_END_DATE_CONTRACT => strtotime($request->end_date_contract),
            Tenancy::COLUMN_KY_TRA => $request->ky_tra,
            Tenancy::COLUMN_CONTRACT_EXPIRY_DATE => $request->contract_expiry_date,
            Tenancy::COLUMN_HOP_DONG_SO => Tenancy::COLUMN_GOC + $countKyHan,
            Tenancy::COLUMN_ONE_MONTH_RENT => $request->one_month_rent,
        ];
        if ($findKyHan['status'] == 'active') {
            if ($timeKyHan < strtotime($request->start_date_contract)) {
                $result = $this->tenancyRepository->updateTenancyKyTra($data, $id);
                $this->findData($id);
                $this->tenancyRepository->log($id, $action, $request->user->email);
                return BaseController::sendResponse(BaseController::HTTP_OK, "insert new success", $result);
            } else {
                $this->tenancyRepository->log($id, $action1, $request->user->email);
                return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, ['start_date_contract'=>["Thời gian bắt đầu không được nhỏ hơn thời gian kết thúc của phụ lục trước"]]);
            }
        } else {
            $this->tenancyRepository->log($id, $action1, $request->user->email);
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, ["insert new error"]);
        }
    }

// chia các kỳ trả
    public function findData($id)
    {
        $resultOne = $this->tenancyRepository->findOne($id);
        log::channel('Tenancy')->info('tìm được hợp đồng theo id ');
        $nguoi_nop_thue = $resultOne['nguoi_nop_thue'];
        $results = $this->tenancyRepository->findDataTenancy($id);
        log::channel('Tenancy')->info('tìm được tất cả các kỳ hạn của bản ghi ');
        $result_ky_han = $this->tenancyRepository->updateStatusKyHan($id);
        log::channel('Tenancy')->info('cập nhật trạng thái của các kỳ hạn của từng hợp đồng');
        foreach ($results as $kyHan) {
            $startTime = Carbon::createFromFormat('d/m/Y', $kyHan['start_date_contract']);
            $endTime = Carbon::createFromFormat('d/m/Y', $kyHan['end_date_contract']);
            $ky_tra = $kyHan['ky_tra'];
            $hopDongSo = $kyHan['hop_dong_so'];
            $one_month_rent = $kyHan['one_month_rent'];
            $status_ky_han = $kyHan['status_ky_han'];
            $firstTime = true;
            $isDifferentYear = $startTime->year == $endTime->year;
            $ky_thanh_toan = 1;
            while ($startTime < $endTime && $status_ky_han == "1") {
                $startDateKyDau = clone  $startTime;
                $endDateKyCuoi = clone $endTime;
                $startDateKy = clone $startTime;
                $endDateKy = clone $startTime;
                $endDateKy->addMonths($kyHan['ky_tra']);
                $endDateKy->subDay(1);
                $tienKy = $one_month_rent * $kyHan['ky_tra'];
                $checkMonth = clone $endTime;
                $check_month = $checkMonth->setMonth(2)->month;
                if ($endDateKy > $endTime) {
                    $endDateKy = clone $endTime;
                    $startDateKyClone = clone $endTime;
                    $startDateKyClone = $startDateKyClone->subMonth(1);
                    $startDateKyClone = $startDateKyClone->setDay($startDateKy->day);
                    //đầu kỳ
                    $startDay = $startDateKyClone->day;
                    $endDay = $startDateKyClone->endOfMonth()->day;
                    $diff = $endDay - $startDay +1;
                    $tienKy1 = ($one_month_rent * $diff/$endDay);
                    //cuối kỳ
                    $thangCuoi = clone $endTime;
                    $ngayCuoiCung = $thangCuoi->day;
                    $ngayDauThangCuathangCuoi = $thangCuoi->startOfMonth()->day;
                    $endDay2 = $thangCuoi->endOfMonth()->day;
                    $diff2 = $ngayCuoiCung - $ngayDauThangCuathangCuoi + 1;
                    $tienKy2 = ($one_month_rent * $diff2/$endDay2);
                    $diffMonths = $thangCuoi->diffInMonths($startDateKy);
                    if ($diffMonths > 1) {
                        $tienKy = $tienKy1 + $tienKy2 + ($one_month_rent * ($diffMonths - 1));
                    } else if ($diffMonths == 1) {
                        $tienKy = $tienKy1 + $tienKy2;
                    } else {
                        $tienKy = $tienKy2;
                    }
                }
                $day = (int)$startTime->day;
                $ngayTra = 20;
                $ngayThanhToan = clone $startTime;
                if ($day >= 15) {
                } else {
                    $ngayThanhToan->subMonth();
                }
                $startTime = $startTime->addMonths($kyHan['ky_tra']);
                $results_payment = $this->PaymentPeriodRepository
                    ->insertData(
                        $ngayThanhToan->format("$ngayTra/m/Y"),
                        $ngayThanhToan->format("Y/m/$ngayTra"),
                        $ky_tra,
                        $hopDongSo,
                        round($tienKy),
                        $resultOne,
                        $id,
                        $nguoi_nop_thue,
                        $startDateKy,
                        $endDateKy,
                        $ky_thanh_toan++
                    );
            }
            log::channel('Tenancy')->info('chia các kỳ thanh toán của từng hợp đồng thành công');
        }
        return BaseController::sendResponse(BaseController::HTTP_OK, "insert new success");
    }


    private function periodDays($start_date, $per)
    {
        $from = new \DateTime($start_date);
        $day = $from->format('j');
        $from->modify('first day of this month');
        $period = new \DatePeriod($from, new \DateInterval('P1M'), $per);
        $arr_date = [];
        foreach ($period as $date) {
            $lastDay = clone $date;
            $lastDay->modify('last day of this month');
            $date->setDate($date->format('Y'), $date->format('n'), $day);
            if ($date > $lastDay) {
                $date = $lastDay;
            }
            $arr_date[] = $date->format('Y-m-d');
        }
        $datetime1 = new \DateTime($arr_date[$per - 1]);
        $datetime2 = new \DateTime($arr_date[$per]);
        $difference = $datetime1->diff($datetime2);
        return array('date' => ($arr_date[$per]), 'days' => $difference->days);
    }

//thanh li hop dong tung bản ghi
    public function Thanh_ly_hop_dong(Request $request, $id)
    {
        $hopDongTl = $this->tenancyRepository->ThanhLiHopDong($id);
        $action = "Thanh lý hợp đồng thành công";
        $action1 = "Thanh lý hợp đồng thất bại";
        if ($hopDongTl && $hopDongTl == true) {
            $this->tenancyRepository->log($id, $action, $request->user->email);
            log::channel('Tenancy')->info(' thanh lý hợp đồng thành công');
            return BaseController::sendResponse(BaseController::HTTP_OK, "Liquidate the contract success");
        } elseif ($hopDongTl == false) {
            $this->tenancyRepository->log($id, $action1, $request->user->email);
            log::channel('Tenancy')->info(' thanh lý hợp đồng thất bại thành công');
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "failed contract liquidation");
        }
    }

//lay tat ca hop dong
    public function get_data_tenancy(Request $request)
    {
        $data = [];
        $data['data'] = $this->tenancyRepository->getDataTenancy($request, $request->typeQuery);
        $data['total'] = $this->tenancyRepository->getDataTenancy($request, 'count');
        foreach ($data['data'] as $item) {
            $address = $item['store']['address'];
            $district = District::where('code',$address)->first();
            if ($district ){
                $item['name_address'] = $district['name'];
            }
        }
        return BaseController::sendResponse(BaseController::HTTP_OK, " Liquidate the contract success", $data);
    }

//update status

    public function update_status($id)
    {
        $tenancy = $this->tenancyRepository->findOne($id);
        if ($tenancy['status'] == 'block') {
            $result = $this->tenancyRepository->updateStatus($id);
            $tenancy1 = $this->tenancyRepository->findOne($id);
            if ($tenancy1['status'] == "active") {
                $this->findData($id);
            }
            log::channel('Tenancy')->info(' cập nhật trạng thái thành công');
            return BaseController::sendResponse(BaseController::HTTP_OK, "cập nhật thành công", $result);
        } else {
            log::channel('Tenancy')->info(' Trạng thái không hợp lệ, hợp đồng đang được kích hoạt');
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "Trạng thái không hợp lệ");

        }
    }

//chi tiết từng hợp đông và các kỳ trả của từng hợp đồng

    public function detail_tenancy($id)
    {
        $result = $this->tenancyRepository->findOne($id);
        $result1 = $this->PaymentPeriodRepository->getAllSameCodeContract($result['code_contract']);
        return BaseController::sendResponse(BaseController::HTTP_OK, " find contract success", ['detail' => $result, 'code' => $result1]);
    }

//lấy logs của từng hợp đồng
    public function findLogs($id)
    {
        $result = $this->tenancyRepository->find_logs($id);
        return $result;
    }

//upload scan hợp đồng
    public function uploadScanHd(Request $request)
    {
        $data = [
            Tenancy::COLUMN_IMAGE_TENANCY => $request->image_tenancy,
            Tenancy::COLUMN_ID => $request->id
        ];
        $result = $this->tenancyRepository->upload_scan_hd($data);
        log::channel('Tenancy')->info(' upload hình ảnh hợp đồng thành công');
        return BaseController::sendResponse(BaseController::HTTP_OK, "insert image success");
    }

//tìm tất cả các phụ lục của từng hợp đồng gốc
    public function findOneAppendix($id)
    {
        $result = $this->tenancyRepository->find_one_appendix($id);
        return BaseController::sendResponse(BaseController::HTTP_OK, "find success", $result);
    }

    //lấy user nhân viên phát triển mặt bằng

    public function findUserPtmb()
    {
        $result = $this->roleRepository->findOneNvPTMB();
        return BaseController::sendResponse(BaseController::HTTP_OK, "find user ptmb succes", $result);
    }

//lịch sử thanh toán tiền cấn cọc

    public function history_payment_deposit($id)
    {
        try {
            $result = $this->tenancyRepository->historyPayMentDeposit($id);
            return BaseController::sendResponse(BaseController::HTTP_OK, "find list deposit succes", $result);
        } catch (Exception $e) {
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
//lịch sử chủ nhà thanh toán tiền cọc
    public function history_payment_deposit_home($id)
    {
        try {
            $result = $this->tenancyRepository->historyPayMentDepositHome($id);
            return BaseController::sendResponse(BaseController::HTTP_OK, "find list deposit succes", $result);
        } catch (Exception $e) {
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }


//validate thêm mới kỳ hạn
    public function findLatsEnddate($id)
    {
        $result = $this->tenancyRepository->findLatsEnddate($id);
        return $result;
    }

//update hợp đồng khi hợp đồng chưa được kích hoạt
    public function update_tenancy_status_block(Request $request, $id)
    {
        try {
            $inputData = $request->all();
            $validate = Validator::make($inputData, [
            "code_contract" => "required",
            "date_contract" => "required",
            "contract_expiry_date" => "required",
            "start_date_contract_uni" => "required",
            "end_date_contract_uni" => "required|after:start_date_contract_uni",
            "address" => "required|string",
            "name_cty" => "required|string",
            "one_month_rent" => "required",
            "ky_tra" => "required",
            "ten_chu_nha" => "required|string",
            "sdt_chu_nha" => "required|numeric|regex:/^[0-9]+$/",
            "ten_tk_chu_nha" => "required|string",
            "so_tk_chu_nha" => "required|regex:/^[0-9]+$/|max:30|min:1",
            "bank_name" => "required|string",
            "tien_coc" => "required",
            "ngay_dat_coc" => "required",
            'dien_tich' => "required",
            'store_name' => "required|string",
        ],
        [
            'code_contract.required' => "Số hợp đồng không được để trống",
            'date_contract.required' => "Ngày ký hợp đồng không được để trống",
            'contract_expiry_date.required' => 'Thời hạn thuê không được để trống',
            'start_date_contract_uni.required' => 'Ngày bắt đầu hợp đồng không được để trống',
            'start_date_contract_uni.date_format' => 'Ngày bắt đầu hợp đồng không đúng định dạng,vd: YYYY-mm-dd',
            'end_date_contract_uni.required' => 'Ngày kết thúc hợp đồng không được để trống',
            'end_date_contract_uni.date_format' => 'Ngày kết thúc hợp đồng không đúng định dạng,vd: YYYY-mm-dd',
            'address.required' => 'Khu vực không được để trống',
            'name_cty.required' => 'Tên công ty hoặc chi nhánh không được để trống',
            'one_month_rent.required' => 'Giá thuê/tháng không được để trống',
            'ten_chu_nha.required' => 'Họ và tên(chủ nhà) không được để trống',
            'sdt_chu_nha.required' => 'Số điện thoại chủ nhà không được để trống',
            'ten_tk_chu_nha.required' => 'Tên chủ tài khoản không được để trống',
            'so_tk_chu_nha.required' => 'Số tài khoản nhận thanh toán không được để trống',
            'bank_name.required' => 'Ngân hàng không được để trống',
            'tien_coc.required' => 'Số tiền đặt cọc không được để trống',
            'ngay_dat_coc.required' => 'Ngày đặt cọc không được để trống',
            'dien_tich.required' => 'Diện tích không được để trống',
            'store_name.required' => 'Tên phòng giao dịch không được để trống',
            'ky_tra.required' => 'Kỳ trả không được để trống',
            'end_date_contract_uni.after' => 'Ngày kết thúc hợp đồng không được nhỏ hơn ngày bắt đầu hợp đồng',
            'so_tk_chu_nha.regex' => 'Số tài khoản không được có ký tự đặc biệt và chữ vd:(- , _, abc , ...)',
            'so_tk_chu_nha.max' => 'Số tài khoản không được vượt quá 30 số',
            'so_tk_chu_nha.min' => 'Số tài khoản không được vượt quá 1 số',
            'sdt_chu_nha.regex' => 'Số điện thoại chủ nhà không được có ký tự đặc biệt vd:(- , _ ,...)',
            'sdt_chu_nha.numeric' => 'Số điện thoại không được nhập chữ',
            'dien_tich.numeric' => 'Diện tích thuê không được nhập chữ',
        ]
        );
            if ($validate->fails()) {
                $action1 = "Cập nhật hợp đồng thất bại";
                log::channel('Tenancy')->info('Validate error ' . $validate->errors());
                //$this->tenancyRepository->log($id, $action1, $request->user->email);
                return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST,$validate->errors());
            }
            $result1 = $this->tenancyRepository->findOne($id);
            $status = $result1['status'];
            if ($status == 'block'){
                $result = $this->tenancyRepository->updateTenancyStatusBlock($inputData, $id);
                return BaseController::sendResponse(BaseController::HTTP_OK, "update succes", $result);
            } elseif($status == 'active' || $status == 'hop_dong_thanh_ly'){
                return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "update error");
            }
        } catch (Exception $e) {
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "update error", $result);
        }
    }

//tìm từng bản ghi tenancy
    public function find_one_id_Tenancy($id)
    {
         $result = $this->tenancyRepository->findOne($id);
         return BaseController::sendResponse(BaseController::HTTP_OK, "update succes", $result);
    }

//thêm ngày thanh lý hợp đồng
    public function thanh_ly_hop_dong_tenancy(Request $request, $id)
    {
        $result = $this->tenancyRepository->findOne($id);
        if ($result['status'] == 'active'){
            $result1 = $this->tenancyRepository->TLHDTenancy($request, $id);
            return BaseController::sendResponse(BaseController::HTTP_OK, "update succes", $result1);
        }else{
            return BaseController::sendResponse(BaseController::HTTP_BAD_REQUEST, "update errors");
        }
    }

//lấy hết tất cả các hợp đồng tồn tại ngày thanh lý
    public function get_all_tenancy_hdtl()
    {
        $result1 = $this->tenancyRepository->getAllTenancyHDTL();
        if (!empty($result1)) {
            foreach ($result1 as $item) {
                $result = $this->tenancyRepository->ThanhLiHopDong($item['_id']);
            }
        }
        return BaseController::sendResponse(BaseController::HTTP_OK, "update succes");
    }


//test
    public function test(Request $request,$id)
    {
        $result1 = $this->tenancyRepository->TLHDTenancy($request,$id);
        return BaseController::sendResponse(BaseController::HTTP_OK, "update succes", $result1);
    }

    public function test1(Request $request)
    {
        $result1 = $this->tenancyRepository->getAllTenancyHDTL();
        if (!empty($result1)){
            foreach ($result1 as $item){
                 $result = $this->tenancyRepository->ThanhLiHopDong($item['_id']);
            }
        }
        return BaseController::sendResponse(BaseController::HTTP_OK, "update succes");
    }


}

