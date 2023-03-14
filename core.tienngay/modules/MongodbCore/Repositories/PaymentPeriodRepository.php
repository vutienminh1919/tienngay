<?php


namespace Modules\MongodbCore\Repositories;


use Carbon\Carbon;
use Modules\MongodbCore\Entities\PaymentPeriod;
use Modules\MongodbCore\Entities\Tenancy;


class PaymentPeriodRepository
{
    protected $paymentPeriodModel;
    protected $tenancymodel;

    public function __construct(PaymentPeriod $paymentPeriod,
                                Tenancy $tenancy)
    {
        $this->paymentPeriodModel = $paymentPeriod;
        $this->tenancymodel = $tenancy;
    }

// chi tiết từng kỳ thanh toán
    public function insertData($ngayThanhToan,$ngayThanhToanUnix, $ky_tra,
                         $hopDongSo, $tienKy, $result, $id, $nguoi_nop_thue,$startDateKy,$endDateKy,$ky_thanh_toan)
    {
        $thueKy = $tienKy;
        $tongThuePhaiTraKy = ($thueKy / 0.9) * 0.1;
        $result1 = [
            'code_contract' => $result['code_contract'],
            'date_contract' => $result['date_contract'],
            'start_date_contract' => ($result['start_date_contract']),
            'end_date_contract' => ($result['end_date_contract']),
            'customer_infor' => $result['customer_infor'],
            'ten_chu_nha' => $result['customer_infor']['ten_chu_nha'],
            'sdt_chu_nha' => $result['customer_infor']['sdt_chu_nha'],
            PaymentPeriod::COLUMN_STATUS_THUE => PaymentPeriod::COLUMN_BLOCK_THUE,
            PaymentPeriod::COLUMN_STATUS => PaymentPeriod::COLUMN_BLOCK,
            PaymentPeriod::COLUMN_NGAY_THANH_TOAN => $ngayThanhToan,
            Tenancy::COLUMN_HOP_DONG_SO => $hopDongSo,
            Tenancy::COLUMN_ONE_MONTH_RENT => $tienKy,
            Tenancy::COLUMN_TIEN_THUE => round($tongThuePhaiTraKy),
            PaymentPeriod::COLUMN_KY_TRA => $ky_tra,
            PaymentPeriod::COLUMN_CONTRACT_ID => $id,
            PaymentPeriod::COLUMN_NGUOI_NOP_THUE => $nguoi_nop_thue,
            PaymentPeriod::COLUMN_NGAY_THANH_TOAN_UNIX => strtotime($ngayThanhToanUnix),
            PaymentPeriod::COLUMN_NGAY_BAT_DAU_KY => strtotime($startDateKy),
            PaymentPeriod::COLUMN_NGAY_KET_THUC_KY => strtotime($endDateKy),
            PaymentPeriod::COLUMN_KY_THANH_TOAN => $ky_thanh_toan
        ];
        return $this->paymentPeriodModel->create($result1)->toArray();
    }

    public function findData($code_contract, $ky_tra)
    {
        return $this->paymentPeriodModel->where(
            PaymentPeriod::COLUMN_CODE_CONTRACT, $code_contract,
            PaymentPeriod::COLUMN_KY_TRA, $ky_tra
        )->first();
    }

//thanh toan từng kỳ (thanh toán bình thường, thanh toán cấn trừ cọc)
    public function paymentTenancy($data)
    {
        $arrDateThanhToan = explode('-', $data[PaymentPeriod::COLUMN_NGAY_THANH_TOAN_TT]);
        $date = date('d/m/Y',strtotime($data[PaymentPeriod::COLUMN_NGAY_THANH_TOAN_TT]));
        $bool = false;
        $resultPayment = $this->paymentPeriodModel
            ->find([PaymentPeriod::COLUMN_ID => $data[PaymentPeriod::COLUMN_ID]])->toArray();
        $one_month_rent = $resultPayment[0]['one_month_rent'];
        $code_contract = $resultPayment[0]['code_contract'];
        $statuspayment = $resultPayment[0]['status'];
        $resultTenancy = $this->tenancymodel
            ->where(Tenancy::COLUMN_CODE_CONTRACT, $code_contract)
            ->first()->toArray();

        $tien_coc_goc = $resultTenancy['tien_coc'];
        $tienCocThua1 = $resultTenancy['tien_coc_thua'];


        //thanh toán bình thường
        if (($one_month_rent == $data[PaymentPeriod::COLUMN_ONE_MONTH_RENT])
            && $code_contract == $data[PaymentPeriod::COLUMN_CODE_CONTRACT]
            && $statuspayment == 'chua_thanh_toan' && empty($data[Tenancy::COLUMN_TIEN_COC])
        ) {
            $resultPaymentUpdateStatus1 = $this->paymentPeriodModel
                ->where(PaymentPeriod::COLUMN_ID, $data[PaymentPeriod::COLUMN_ID])
                ->update(
                    [PaymentPeriod::COLUMN_STATUS => PaymentPeriod::COLUMN_ACTIVE,
                        PaymentPeriod::COLUMN_NGAY_THANH_TOAN_TT =>  $date,
                        //PaymentPeriod::COLUMN_NGAY_DEN_HAN_TT_THUE => Carbon::create($arrDateThanhToan[0],$arrDateThanhToan[1],$arrDateThanhToan[2])->addDays(10)->format('d/m/Y')
                        PaymentPeriod::COLUMN_NGAY_DEN_HAN_TT_THUE => (Carbon::parse($data[PaymentPeriod::COLUMN_NGAY_THANH_TOAN_TT])->addDays(10)->unix())
                    ]
                );
            $bool = true;
            // số tiền thanh toán khác với  thanh toán có cấn trừ cọc
        } elseif (($one_month_rent != $data[PaymentPeriod::COLUMN_ONE_MONTH_RENT]
                + $data[Tenancy::COLUMN_TIEN_COC]) &&
            $code_contract == $data[PaymentPeriod::COLUMN_CODE_CONTRACT]
            && $statuspayment == 'chua_thanh_toan') {
            $bool = false;
            // thanh toán có cấn trừ cọc
        } elseif (($one_month_rent == $data[PaymentPeriod::COLUMN_ONE_MONTH_RENT]
                + $data[Tenancy::COLUMN_TIEN_COC]) &&
            $code_contract == $data[PaymentPeriod::COLUMN_CODE_CONTRACT]
            && $statuspayment == 'chua_thanh_toan' && $tienCocThua1 > "0" && $data[Tenancy::COLUMN_TIEN_COC] < $tienCocThua1
        ) {
            $data1 = [
                'coc_can_thua' => $data[Tenancy::COLUMN_TIEN_COC],
                'ngay_thanh_toan' => time(),
                'nguoi_thanh_toan' => $data[Tenancy::COLUMN_CREATED_BY],
                'tien_coc_goc' => $tien_coc_goc,
            ];

            //thêm  số tiền thanh toán cấn cọc
            $cocCanThua = $this->tenancymodel->where([
                Tenancy::COLUMN_CODE_CONTRACT => $code_contract
            ])->push('tien_can_coc', $data1);

            $resultData = $this->tenancymodel
                ->where([Tenancy::COLUMN_CODE_CONTRACT => $code_contract])
                ->first()
                ->toArray();

            if (!empty($resultData['tien_coc_chu_nha'])) {
                $tien_coc_chu_nha_thanh_toan = [];
                $tien_coc_chu_nha_tt = $resultData['tien_coc_chu_nha'];
                foreach ($tien_coc_chu_nha_tt as $va) {
                    $tien_coc_chu_nha_thanh_toan[] = $va['coc_bctt'];
                    $tong_tien_coc_chu_nha_tt = array_sum($tien_coc_chu_nha_thanh_toan);
                }
            }

            $tienCanCoc = [];
            $tien_can_coc = $resultData['tien_can_coc'];
            foreach ($tien_can_coc as $i) {
                $tienCanCoc[] = $i['coc_can_thua'];
                $tongTienCanCoc = array_sum($tienCanCoc);
            }

            if (!empty($tong_tien_coc_chu_nha_tt)){
                $tienCocThua = $tien_coc_goc - ($tongTienCanCoc + $tong_tien_coc_chu_nha_tt);
            }else{
                $tienCocThua = $tien_coc_goc - $tongTienCanCoc;
            }

            $resultPaymentUpdateStatus2 = $this->paymentPeriodModel
                ->where(PaymentPeriod::COLUMN_ID, $data[PaymentPeriod::COLUMN_ID])
                ->update(
                    [PaymentPeriod::COLUMN_STATUS => PaymentPeriod::COLUMN_ACTIVE,
                        PaymentPeriod::COLUMN_NGAY_THANH_TOAN_TT => $date,
                        //PaymentPeriod::COLUMN_NGAY_DEN_HAN_TT_THUE => Carbon::create($arrDateThanhToan[0],$arrDateThanhToan[1],$arrDateThanhToan[2])->addDays(10)->format('d/m/Y')
                        PaymentPeriod::COLUMN_NGAY_DEN_HAN_TT_THUE => (Carbon::parse($data[PaymentPeriod::COLUMN_NGAY_THANH_TOAN_TT])->addDays(10)->unix())
                    ]
                );
            $tienCoc = $this->tenancymodel
                ->where(Tenancy::COLUMN_CODE_CONTRACT, $code_contract)
                ->update([Tenancy::COLUMN_TIEN_COC_THUA => $tienCocThua]);
            $bool = true;
        } elseif (($one_month_rent != $data[PaymentPeriod::COLUMN_ONE_MONTH_RENT])
            && $code_contract == $data[PaymentPeriod::COLUMN_CODE_CONTRACT]
            && $statuspayment == 'chua_thanh_toan') {
            $bool = false;
        }
        return $bool;
    }


// cập nhật tiền cọc sau  khi bên  cho thuê thanh toán

    public function updateTienCocChuNha($data, $id)
    {
        $result = $this->tenancymodel->where([
            Tenancy::COLUMN_STATUS => Tenancy::COLUMN_ACTIVE,
            Tenancy::COLUMN_ID => $id
        ])->first()->toArray();
        $idResultCoc = $result['_id'];
        $cocBanDau = $result['tien_coc'];
        $data1 = [
            'coc_bctt' => $data[Tenancy::COLUMN_COC_BCTT],
            'ngay_thanh_toan_coc' => strtotime($data[Tenancy::COLUMN_NGAY_THANH_TOAN_COC]) ?? null,
            'tien_coc_ban_dau' => $cocBanDau,
            'nguoi_cap_nhat_tt' => $data->user->email ?? null,
        ];
        $result_coc_chu_nha = $this->tenancymodel->where([
            Tenancy::COLUMN_ID => $idResultCoc
        ])->push('tien_coc_chu_nha', $data1);

        $result1 = $this->tenancymodel->where([
            Tenancy::COLUMN_ID => $idResultCoc
        ])->first()->toArray();

        $tien_con_con_lai1 = $result1['tien_coc_thua'];
        $tien_con_goc_ban_dau = $result1['tien_coc'];


        if (!empty($result1['tien_can_coc'])) {
            $tong_tien_coc_cty_thanh_toan = [];
            $tien_can_coc = $result1['tien_can_coc'];
            foreach ($tien_can_coc as $va) {
                $tong_tien_coc_cty_thanh_toan[] = $va['coc_can_thua'];
                $tongTienCocCtyThanhToan = array_sum($tong_tien_coc_cty_thanh_toan);
            }
        }

        $tongTienCoc = [];
        $tien_coc_chu_nha = $result1['tien_coc_chu_nha'];
        foreach ($tien_coc_chu_nha as $t) {
            $tongTienCoc[] = $t['coc_bctt'];
            $tongCocThue = array_sum($tongTienCoc);
        }

        if (!empty($tongTienCocCtyThanhToan)){
             $tien_con_con_lai = $tien_con_goc_ban_dau - ($tongCocThue + $tongTienCocCtyThanhToan);
        }else{
            $tien_con_con_lai = $tien_con_goc_ban_dau - $tongCocThue;
        }
        $updateCoc = $this->tenancymodel->where(
            [
                Tenancy::COLUMN_ID => $idResultCoc
            ]
        )->update([
            Tenancy::COLUMN_TIEN_COC_THUA => $tien_con_con_lai
        ]);
        return $tien_con_con_lai;
    }

//thanh toán thuế từng bản ghi
    public function ThanhToanThue($data)
    {
        $bool = false;
        $resultThue = $this->paymentPeriodModel
            ->find([PaymentPeriod::COLUMN_ID => $data[PaymentPeriod::COLUMN_ID]])
            ->toArray();
        $tienThue = $resultThue[0]['tien_thue'];
        $code_contract = $resultThue[0]['code_contract'];
        if ($tienThue == $data[PaymentPeriod::COLUMN_TIEN_THUE] && $code_contract ==
            $data[PaymentPeriod::COLUMN_CODE_CONTRACT]
        ) {
            $resultPaymentUpdateStatus = $this->paymentPeriodModel
                ->where(PaymentPeriod::COLUMN_ID, $data[PaymentPeriod::COLUMN_ID])
                ->update(
                    [PaymentPeriod::COLUMN_STATUS_THUE => PaymentPeriod::COLUMN_ACTIVE_THUE,
                        PaymentPeriod::COLUMN_NGAY_THANH_TOAN_THUE => strtotime($data[PaymentPeriod::COLUMN_NGAY_THANH_TOAN_THUE]),
                        PaymentPeriod::COLUMN_IMAGE_THUE => $data[PaymentPeriod::COLUMN_IMAGE_THUE]
                    ]
                );
            $bool = true;
        } else {
            $bool = false;
        }
        return $bool;
    }


//tìm kiếm bản ghi tới hạn thanh toán trong thánh (các bản ghi từ đầu tháng tới cuối tháng đó)

    public function findDataToiHan($request)
    {
        //$curent_time = time();
        $start = (Carbon::now()->firstOfMonth()->unix());
        $end = (Carbon::now()->lastOfMonth()->unix());
        $curentTime = date("d/m/Y");
        $result = $this->paymentPeriodModel;
        if (!empty($request->status)) {
            $result = $result->where(PaymentPeriod::COLUMN_STATUS, $request->status);
        }

        if (!empty($request->status_thue)) {
            $result = $result->where(PaymentPeriod::COLUMN_STATUS_THUE, $request->status_thue);
        }

        if (!empty($request->code_contract)) {
            $result = $result->where(PaymentPeriod::COLUMN_CODE_CONTRACT, $request->code_contract);
        }

        $result = $result->where(function ($query) {
            return $query
                ->where(PaymentPeriod::COLUMN_STATUS, PaymentPeriod::COLUMN_BLOCK)
                ->orWhere(PaymentPeriod::COLUMN_STATUS_THUE, PaymentPeriod::COLUMN_BLOCK_THUE);
        })
            ->whereBetween(PaymentPeriod::COLUMN_NGAY_THANH_TOAN_UNIX ,[$start,$end])
            ->get()->toArray();
        return $result;
    }

//tìm kiếm bản ghi quá hạn thanh toán (quá hạn ngày thanh toán)

    public function findDataQuaHan($request)
    {
        $result = $this->paymentPeriodModel;
        $curentTime = time();
        $dataQuahan = [];
        if (!empty($request->status)) {
            $result = $result->where(PaymentPeriod::COLUMN_STATUS, $request->status);
        }

        if (!empty($request->status_thue)) {
            $result = $result->where(PaymentPeriod::COLUMN_STATUS_THUE, $request->status_thue);
        }

        if (!empty($request->code_contract)) {
            $result = $result->where(PaymentPeriod::COLUMN_CODE_CONTRACT, $request->code_contract);
        }
        $result = $result->where(function ($query) {
            return $query->where(PaymentPeriod::COLUMN_STATUS, PaymentPeriod::COLUMN_BLOCK)
                ->orWhere(PaymentPeriod::COLUMN_STATUS_THUE, PaymentPeriod::COLUMN_BLOCK_THUE);
        });

        $result = $result->get()->toArray();
        foreach ($result as $item) {
            $ngayQuaHan = strtotime(trim(str_replace("/", "-", $item['ngay_thanh_toan'])) . ' 23:59:59');
            if ($ngayQuaHan < $curentTime) {
                $dataQuahan[] = $item;

            }
        }
        for ($i = 0; $i < count($dataQuahan); $i++) {
            $max = $i;
            for ($j = $i + 1; $j < count($dataQuahan); $j++) {
                if ($dataQuahan[$j]['ngay_thanh_toan_unix'] > $dataQuahan[$max]['ngay_thanh_toan_unix']) {
                    $max = $j;
                }
            }
            $temp = $dataQuahan[$i];
            $dataQuahan[$i] = $dataQuahan[$max];
            $dataQuahan[$max] = $temp;
        }
        return ($dataQuahan);
    }

//ghi chú từng bản ghi

    public function noteTenancy($data)
    {
        $user = session('user');
        $data1 = [
            PaymentPeriod::COLUMN_NOTE => $data[PaymentPeriod::COLUMN_NOTE],
            PaymentPeriod::COLUMN_NOTE_DESCRIPTION => $data[PaymentPeriod::COLUMN_NOTE_DESCRIPTION],
            PaymentPeriod::CREATED_AT => time(),
            PaymentPeriod::COLUMN_CREATED_BY => $data[PaymentPeriod::COLUMN_CREATED_BY]
        ];
        $result = $this->paymentPeriodModel->where(PaymentPeriod::COLUMN_ID, $data[PaymentPeriod::COLUMN_ID])
            ->push('noteOneTenancy', $data1);
        return "";
    }

//lấy các bản ghi có cùng code_contract
    public function getAllSameCodeContract($code_contract)
    {
        $result = $this->paymentPeriodModel
            ->where(PaymentPeriod::COLUMN_CODE_CONTRACT, $code_contract)
            ->get()->toArray();
        return $result;
    }

//tìm từng bản ghi của từng kỳ
    public function findOnePaymentPeriod($id)
    {
        $result = $this->paymentPeriodModel
            ->find($id);
        return $result;
    }

//tim chứng từ của từng kỳ thanh toán

    public function find_image_ky_han($request)
    {
        $result = $this->paymentPeriodModel->where(
            PaymentPeriod::COLUMN_ID, $request->id
        )->first();
        if ($result) {
            $imagePayment = $result['image_thue'];
        }
        return $imagePayment;
    }

//số tiền thanh toán phải trả
    public function find_sum_money_1($request)
    {
        $result_tong_tien_phai_tra = $this->paymentPeriodModel
            ->where([PaymentPeriod::COLUMN_CODE_CONTRACT => $request->code_contract])
            ->whereIn(
                PaymentPeriod::COLUMN_STATUS, [PaymentPeriod::COLUMN_BLOCK, PaymentPeriod::COLUMN_ACTIVE, PaymentPeriod::COLUMN_HOP_DONG_THANH_LY]
            )
            ->get()->toArray();
        $tongTienTra = [];
        foreach ($result_tong_tien_phai_tra as $key => $value) {
            $tongTienThanhToan = $value['one_month_rent'];
            array_push($tongTienTra, $tongTienThanhToan);
        }
        $tongTienThanhToanDK = array_sum($tongTienTra);

        return $tongTienThanhToanDK;
    }

//số tiền thanh toán đã trả thực tế
    public function find_sum_money_2($request)
    {
        $result_tong_tien_da_tra = $this->paymentPeriodModel
            ->where([PaymentPeriod::COLUMN_CODE_CONTRACT => $request->code_contract,
                PaymentPeriod::COLUMN_STATUS => PaymentPeriod::COLUMN_ACTIVE
            ])
            ->get()->toArray();
        $tongTienPhaiTra = [];
        foreach ($result_tong_tien_da_tra as $ke => $va) {
            $tienPhaiTra = $va['one_month_rent'];
            array_push($tongTienPhaiTra, $tienPhaiTra);
        }
        $tongTienPhaiTraTT = array_sum($tongTienPhaiTra);
        return $tongTienPhaiTraTT;
    }

// số tiền thanh toán thuế phải trả

    public function find_sum_money_pax($request)
    {
        $result_tong_tien_thue_phai_tra = $this->paymentPeriodModel
            ->where([PaymentPeriod::COLUMN_CODE_CONTRACT => $request->code_contract])
            ->whereIn(
                PaymentPeriod::COLUMN_STATUS_THUE, [PaymentPeriod::COLUMN_BLOCK_THUE, PaymentPeriod::COLUMN_ACTIVE_THUE, PaymentPeriod::COLUMN_HOP_DONG_THANH_LY]
            )
            ->get()->toArray();
        $arr_tong_tien_thue = [];
        foreach ($result_tong_tien_thue_phai_tra as $key => $value) {
            $tong_tien_thue = $value['tien_thue'];
            array_push($arr_tong_tien_thue, $tong_tien_thue);
        }
        $sum_tong_tien_thue = array_sum($arr_tong_tien_thue);
        return $sum_tong_tien_thue;
    }

    //số tiền thuế đã thanh toán thực tế

    public function find_sum_money_pax1($request)
    {
        $result_tong_tien_thue_da_tra = $this->paymentPeriodModel
            ->where([PaymentPeriod::COLUMN_CODE_CONTRACT => $request->code_contract,
                PaymentPeriod::COLUMN_STATUS_THUE => PaymentPeriod::COLUMN_ACTIVE_THUE
            ])
            ->get()->toArray();
        $arr_tien_thue_da_tra = [];
        foreach ($result_tong_tien_thue_da_tra as $key => $value) {
            $tong_tien_thue_tra_thuc_te = $value['tien_thue'];
            array_push($arr_tien_thue_da_tra, $tong_tien_thue_tra_thuc_te);
        }
        $sum_tong_tien_thue_tra_thuc_te = array_sum($arr_tien_thue_da_tra);
        return $sum_tong_tien_thue_tra_thuc_te;
    }
//Gửi email các hợp đồng có kỳ tới hạn
    public function sendMailToiHan()
    {
        $curentTime = date("Y-m-d");
        $result = $this->paymentPeriodModel;
        $result = $result->where(function ($query) {
            return $query
                ->where(PaymentPeriod::COLUMN_STATUS, PaymentPeriod::COLUMN_BLOCK)
                ->orWhere(PaymentPeriod::COLUMN_STATUS_THUE, PaymentPeriod::COLUMN_BLOCK_THUE);
        })
            ->where([PaymentPeriod::COLUMN_NGAY_THANH_TOAN => $curentTime])
            ->get()->toArray();
        return $result;
    }

    public function deleteExistedKyHan($codeContract, $startTime, $endTime) {
        return $this->paymentPeriodModel
        ->where(PaymentPeriod::COLUMN_CODE_CONTRACT, $codeContract,)
        ->where(PaymentPeriod::COLUMN_NGAY_THANH_TOAN_UNIX, '>', strtotime($startTime))
        ->where(PaymentPeriod::COLUMN_NGAY_THANH_TOAN_UNIX, '<=', strtotime($endTime))
        ->delete();
    }

//update kỳ trả của từng hợp đồng
    public function updatePaymentKyHan($request,$id)
    {
        $result_id = $this->paymentPeriodModel->find($request->_id)->toArray();
        $ky_tra = $result_id['ky_tra'];
        $result = [];
        if (isset($request['code_contract'])) {
            $result[PaymentPeriod::COLUMN_CODE_CONTRACT] = $request['code_contract'];
        }

        if (isset($request['ngay_thanh_toan'])) {
            $result[PaymentPeriod::COLUMN_NGAY_THANH_TOAN] = $request['ngay_thanh_toan'];
        }

        if (isset($request['one_month_rent'])) {
            $result[PaymentPeriod::COLUMN_ONE_MONTH_RENT] = $request['one_month_rent'];
        }

        if (isset($request['ky_tra'])) {
            $result[PaymentPeriod::COLUMN_KY_TRA] = $request['ky_tra'];
        }

        if (isset($request['ngay_thanh_toan'])) {
            $result[PaymentPeriod::COLUMN_NGAY_THANH_TOAN_UNIX] = strtotime($request['ngay_thanh_toan']);
        }

        if (!empty($request['ky_tra']) && $request['ky_tra'] != $ky_tra) {
            $tien_thue = ((($request['one_month_rent'] / $request['ky_tra']) * $request['ky_tra']) / 0.9) * 0.1;
            $result[PaymentPeriod::COLUMN_TIEN_THUE] = $tien_thue;
        }else{
            $tien_thue = ((($request['one_month_rent'] / $ky_tra) * $ky_tra) / 0.9) * 0.1;
            $result[PaymentPeriod::COLUMN_TIEN_THUE] = $tien_thue;
        }

        if (empty($result)){
            return false;
        }

        $updatePayment = $this->paymentPeriodModel->where(
            [PaymentPeriod::COLUMN_ID => $request->_id]
        )->update($result);
         return $updatePayment;
    }

    public function findOnePaymentPeriodKyHan($request)
    {
        $result = $this->paymentPeriodModel
            ->find($request->_id)->toArray();
        return $result;
    }

}
