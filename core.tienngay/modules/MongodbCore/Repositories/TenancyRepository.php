<?php


namespace Modules\MongodbCore\Repositories;


use Carbon\Carbon;
use Modules\MongodbCore\Entities\PaymentPeriod;
use Modules\MongodbCore\Entities\Tenancy;
use Modules\Tenancy\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Log;

class TenancyRepository
{
    protected $tenancyModel;
    protected $paymentPeriodModel;

    public function __construct(Tenancy $tenancy,
                                 PaymentPeriod $paymentPeriod)
    {
        $this->tenancyModel = $tenancy;
        $this->paymentPeriodModel = $paymentPeriod;
    }

//Tạo mới hợp đồng thuê mặt bằng

    public function createTenancy($request)
    {
        $user =session('user');
        $tongThuePhaiTraKy = (($request->one_month_rent * $request->ky_tra) / 0.9) * 0.1;
        $result = [
            Tenancy::COLUMN_CODE_CONTRACT => $request->code_contract ?? null,
            Tenancy::COLUMN_DATE_CONTRACT => !empty($request->date_contract) ? (strtotime($request->date_contract)) : null,
            Tenancy::COLUMN_CONTRACT_EXPIRY_DATE => $request->contract_expiry_date ?? null,
            Tenancy::COLUMN_START_DATE_CONTRACT =>!empty($request->start_date_contract) ? date('d/m/Y', strtotime($request->start_date_contract))  : null,
            Tenancy::COLUMN_END_DATE_CONTRACT =>!empty($request->end_date_contract) ? date('d/m/Y', strtotime($request->end_date_contract))  : null,
            Tenancy::COLUMN_STORE => $request->store ?? null,
            Tenancy::COLUMN_ADDRESS => $request->address ?? null,
            Tenancy::COLUMN_STORE_NAME => $request->store_name ?? null,
            Tenancy::COLUMN_NAME_CTY => $request->name_cty ?? null,
            Tenancy::COLUMN_STAFF_PTMB => $request->staff_ptmb ?? null,
            Tenancy::COLUMN_ONE_MONTH_RENT => $request->one_month_rent ?? null,
            Tenancy::COLUMN_KY_TRA => $request->ky_tra ?? null,
            Tenancy::COLUMN_CUSTOMER_INFOR => $request->customer_infor ?? null,
            Tenancy::COLUMN_TEN_CHU_NHA => $request->ten_chu_nha ?? null,
            Tenancy::COLUMN_SDT_CHU_NHA => $request->sdt_chu_nha ?? null,
            Tenancy::COLUMN_TEN_TK_CHU_NHA => $request->ten_tk_chu_nha ?? null,
            Tenancy::COLUMN_SO_TK_CHU_NHA => $request->so_tk_chu_nha ?? null,
            Tenancy::COLUMN_BANK_NAME => $request->bank_name ?? null,
            Tenancy::COLUMN_TIEN_COC => $request->tien_coc ?? null,
            Tenancy::COLUMN_NGAY_DAT_COC => !empty($request->ngay_dat_coc) ? (strtotime($request->ngay_dat_coc)) : null,
            Tenancy::COLUMN_TIEN_COC_THUA => $request->tien_coc ?? null,
            Tenancy::COLUMN_MA_SO_THUE => $request->ma_so_thue ?? null,
            Tenancy::COLUMN_NGUOI_NOP_THUE => $request->nguoi_nop_thue ?? null,
            Tenancy::COLUMN_CREATED_BY => $request->user->email ?? null,
            Tenancy::COLUMN_STATUS => Tenancy::COLUMN_BLOCK,
            Tenancy::COLUMN_HOP_DONG_SO => Tenancy::COLUMN_GOC,
            Tenancy::COLUMN_TIEN_THUE => round($tongThuePhaiTraKy),
            Tenancy::COLUMN_CREATED_AT => time(),
            Tenancy::COLUMN_DIEN_TICH => $request->dien_tich ?? null,
            Tenancy::COLUMN_START_DATE_CONTRACT_UNI => !empty($request->start_date_contract) ? strtotime($request->start_date_contract) : null,
            Tenancy::COLUMN_END_DATE_CONTRACT_UNI =>!empty($request->end_date_contract) ? strtotime($request->end_date_contract) : null,
        ];

        $result_data = $this->tenancyModel->create($result);
        return $result_data;
    }
// gia hạn hợp đồng thuê nhà 1
    public function updateTenancyKyTraTenancy($request, $id)
    {
        $result = [
            Tenancy::COLUMN_START_DATE_CONTRACT => date('d/m/Y',strtotime($request[Tenancy::COLUMN_START_DATE_CONTRACT])) ?? null,
            Tenancy::COLUMN_END_DATE_CONTRACT => date('d/m/Y',strtotime($request[Tenancy::COLUMN_END_DATE_CONTRACT])) ?? null,
            Tenancy::COLUMN_KY_TRA => $request[Tenancy::COLUMN_KY_TRA] ?? null,
            Tenancy::COLUMN_CONTRACT_EXPIRY_DATE => $request[Tenancy::COLUMN_CONTRACT_EXPIRY_DATE] ?? null,
            Tenancy::COLUMN_HOP_DONG_SO =>  Tenancy::COLUMN_GOC,
            Tenancy::COLUMN_ONE_MONTH_RENT => $request[Tenancy::COLUMN_ONE_MONTH_RENT] ?? null,
            Tenancy::CREATED_AT => time(),
            Tenancy::COLUMN_STATUS_KY_HAN => Tenancy::COLUMN_BLOCK_KY_HAN,
            Tenancy::COLUMN_START_DATE_CONTRACT_UNI => !empty($request[Tenancy::COLUMN_START_DATE_CONTRACT]) ? strtotime($request[Tenancy::COLUMN_START_DATE_CONTRACT]) : null,
            Tenancy::COLUMN_END_DATE_CONTRACT_UNI =>!empty($request[Tenancy::COLUMN_END_DATE_CONTRACT]) ? strtotime($request[Tenancy::COLUMN_END_DATE_CONTRACT]) : null,
        ];
        if (empty($result)) {
            return false;
        }
        $update_tenancy = $this->tenancyModel
            ->where($this->tenancyModel::COLUMN_ID, $id)
            ->push(Tenancy::COLUMN_KY_HAN, $result);
        return $update_tenancy;
    }

// gia hạn hợp đồng thuê nhà 2
    public function updateTenancyKyTra($request, $id)
    {
        $result = [
            Tenancy::COLUMN_START_DATE_CONTRACT => date('d/m/Y',($request[Tenancy::COLUMN_START_DATE_CONTRACT])) ?? null,
            Tenancy::COLUMN_END_DATE_CONTRACT => date('d/m/Y',($request[Tenancy::COLUMN_END_DATE_CONTRACT])) ?? null,
            Tenancy::COLUMN_KY_TRA => $request[Tenancy::COLUMN_KY_TRA] ?? null,
            Tenancy::COLUMN_CONTRACT_EXPIRY_DATE => $request[Tenancy::COLUMN_CONTRACT_EXPIRY_DATE] ?? null,
            Tenancy::COLUMN_HOP_DONG_SO => $request[Tenancy::COLUMN_HOP_DONG_SO],
            Tenancy::COLUMN_ONE_MONTH_RENT => $request[Tenancy::COLUMN_ONE_MONTH_RENT],
            Tenancy::CREATED_AT => time(),
            Tenancy::COLUMN_STATUS_KY_HAN => Tenancy::COLUMN_BLOCK_KY_HAN,
            Tenancy::COLUMN_START_DATE_CONTRACT_UNI => ($request[Tenancy::COLUMN_START_DATE_CONTRACT]) ?? null,
            Tenancy::COLUMN_END_DATE_CONTRACT_UNI =>($request[Tenancy::COLUMN_END_DATE_CONTRACT]) ?? null,
        ];
        if (empty($result)) {
            return false;
        }
        $update_tenancy = $this->tenancyModel
                    ->where($this->tenancyModel::COLUMN_ID,$id)
                    ->push(Tenancy::COLUMN_KY_HAN,$result);
        return $update_tenancy;
    }
//sửa họp đồng
    public function updateTenancy($data, $id)
    {
        $result = [];
        if (isset($data['code_contract'])) {
            $result[$this->tenancyModel::COLUMN_CODE_CONTRACT] = $data['code_contract'];
        }
        if (isset($data['date_contract'])) {
            $result[$this->tenancyModel::COLUMN_DATE_CONTRACT] = $data['date_contract'];
        }
        if (isset($data['contract_expiry_date'])) {
            $result[$this->tenancyModel::COLUMN_CONTRACT_EXPIRY_DATE] = $data['contract_expiry_date'];
        }
        if (isset($data['start_date_contract'])) {
            $result[$this->tenancyModel::COLUMN_START_DATE_CONTRACT] = $data['start_date_contract'];
        }
        if (isset($data['end_date_contract'])) {
            $result[$this->tenancyModel::COLUMN_END_DATE_CONTRACT] = $data['end_date_contract'];
        }
        if (isset($data['end_date_contract'])) {
            $result[$this->tenancyModel::COLUMN_END_DATE_CONTRACT] = $data['end_date_contract'];
        }
        if (isset($data['store'])) {
            $result[$this->tenancyModel::COLUMN_STORE] = $data['store'];
        }
        if (isset($data['store.address'])) {
            $result[$this->tenancyModel::COLUMN_ADDRESS] = $data['store.address'];
        }
        if (isset($data['name_cty'])) {
            $result[$this->tenancyModel::COLUMN_NAME_CTY] = $data['name_cty'];
        }
        if (isset($data['staff_ptmb'])) {
            $result[$this->tenancyModel::COLUMN_STAFF_PTMB] = $data['staff_ptmb'];
        }
        if (isset($data['one_month_rent'])) {
            $result[$this->tenancyModel::COLUMN_ONE_MONTH_RENT] = $data['one_month_rent'];
        }
        if (isset($data['ky_han'])) {
            $result[$this->tenancyModel::COLUMN_KY_HAN] = $data['ky_han'];
        }
        if (isset($data['customer_infor'])) {
            $result[$this->tenancyModel::COLUMN_CUSTOMER_INFOR] = $data['customer_infor'];
        }
        if (isset($data['customer_infor.ten_chu_nha'])) {
            $result[$this->tenancyModel::COLUMN_TEN_CHU_NHA] = $data['customer_infor.ten_chu_nha'];
        }
        if (isset($data['customer_infor.sdt_chu_nha'])) {
            $result[$this->tenancyModel::COLUMN_SDT_CHU_NHA] = $data['customer_infor.sdt_chu_nha'];
        }
        if (isset($data['customer_infor.ten_tk_chu_nha'])) {
            $result[$this->tenancyModel::COLUMN_TEN_TK_CHU_NHA] = $data['customer_infor.ten_tk_chu_nha'];
        }
        if (isset($data['customer_infor.so_tk_chu_nha'])) {
            $result[$this->tenancyModel::COLUMN_SO_TK_CHU_NHA] = $data['customer_infor.so_tk_chu_nha'];
        }
        if (isset($data['customer_infor.bank_name'])) {
            $result[$this->tenancyModel::COLUMN_BANK_NAME] = $data['customer_infor.bank_name'];
        }
        if (isset($data['tien_coc'])) {
            $result[$this->tenancyModel::COLUMN_TIEN_COC] = $data['tien_coc'];
        }
        if (isset($data['ngay_dat_coc'])) {
            $result[$this->tenancyModel::COLUMN_NGAY_DAT_COC] = $data['ngay_dat_coc'];
        }
        if (isset($data['tien_coc_thua'])) {
            $result[$this->tenancyModel::COLUMN_TIEN_COC_THUA] = $data['tien_coc_thua'];
        }
        if (isset($data['ma_so_thue'])) {
            $result[$this->tenancyModel::COLUMN_MA_SO_THUE] = $data['ma_so_thue'];
        }
        if (isset($data['nguoi_nop_thue'])) {
            $result[$this->tenancyModel::COLUMN_NGUOI_NOP_THUE] = $data['nguoi_nop_thue'];
        }
        if (isset($data['created_by'])) {
            $result[$this->tenancyModel::COLUMN_CREATED_BY] = $data['created_by'];
        }
        if (isset($data['update_by'])) {
            $result[$this->tenancyModel::COLUMN_UPDATED_BY] = $data['update_by'];
        }
        if (isset($data['status'])) {
            $result[$this->tenancyModel::COLUMN_STATUS] = $data['status'];
        }
        if (isset($data['ky_tra'])) {
            $result[$this->tenancyModel::COLUMN_KY_TRA] = $data['ky_tra'];
        }
        if (empty($result)) {
            return false;
        }
        $update_tenancy = $this->tenancyModel
        ->where([
            Tenancy::COLUMN_STATUS => Tenancy::COLUMN_ACTIVE,
            Tenancy::COLUMN_ID => $id
        ])
        ->update($result);
        return $update_tenancy;
    }

    public function findData()
    {
        return  $this->tenancyModel
            ->where([Tenancy::COLUMN_STATUS => Tenancy::COLUMN_ACTIVE])
            ->get()->toArray();
    }
//tìm kỳ hạn của hợp đồng
    public function findDataTenancy($id)
    {
        $ky_han = [];
        $result = $this->tenancyModel
            ->select([Tenancy::COLUMN_KY_HAN])
            ->where([Tenancy::COLUMN_STATUS => Tenancy::COLUMN_ACTIVE,
                Tenancy::COLUMN_ID => $id
            ])
            ->get()->toArray();
        if (!empty($result)) {
            foreach ($result as $item) {
                if ($item) {
                    $kyHan = $item["ky_han"];
                    foreach ($kyHan as $v) {
                        $ky_han[] = $v;
                    }
                }
            }
        }
        return $ky_han;
    }
//tìm từng hợp đồng
    public function findOne($id)
    {
        return $this->tenancyModel
            ->find($id)->toArray();
    }

//thanh li hop dong tung bản ghi
    public function ThanhLiHopDong($id)
    {
        $bool = false;
        $findHopDong = $this->tenancyModel->find($id)->toArray();
        $statusTenancy = $findHopDong['status'];
        $codeContract = $findHopDong['code_contract'];
        $cocThua = $findHopDong['tien_coc_thua'];
        if ($statusTenancy == "active") {
            $hopDongTlpayment = $this->paymentPeriodModel
                ->where([PaymentPeriod::COLUMN_CODE_CONTRACT => $codeContract])
                ->where([PaymentPeriod::COLUMN_STATUS => PaymentPeriod::COLUMN_BLOCK])
                ->update([
                    PaymentPeriod::COLUMN_STATUS => PaymentPeriod::COLUMN_HOP_DONG_THANH_LY,
                    PaymentPeriod::COLUMN_NGAY_TLHD => Carbon::now()->format('d/m/Y'),
                    PaymentPeriod::COLUMN_STATUS_THUE => PaymentPeriod::COLUMN_HOP_DONG_THANH_LY
                ]);
            $hopDongTlTenancy = $this->tenancyModel->where(
                [Tenancy::COLUMN_CODE_CONTRACT => $codeContract]
            )->update([Tenancy::COLUMN_STATUS => Tenancy::COLUMN_HOP_DONG_THANH_LY,
            Tenancy::COLUMN_NGAY_TLHD => Carbon::now()->format('d/m/Y')]);
            $bool = true;
        }else{
            $bool= false;
        }
        return $bool;
    }
//lấy hết tất cả các  hợp đồng
    public function getDataTenancy($request,$type)
    {
        $result = $this->tenancyModel;
        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 15;
        if (!empty($request->status)) {
            $result = $result->where(Tenancy::COLUMN_STATUS, $request->status);
        }

        if (!empty($request->start_date_contract_uni)) {
            $startDate = strtotime($request->start_date_contract_uni . ' 00:00:00');
            $result = $result->where(Tenancy::COLUMN_START_DATE_CONTRACT_UNI, '>=', $startDate);
        }

        if (!empty($request->end_date_contract_uni)) {
            $endDate = strtotime($request->end_date_contract_uni . ' 23:59:59');
            $result = $result->where(Tenancy::COLUMN_END_DATE_CONTRACT_UNI, '<=', $endDate);
        }

        if (!empty($request->code_contract)) {
            $result = $result->where(Tenancy::COLUMN_CODE_CONTRACT, $request->code_contract);
        }

        $result = $result
            ->whereIn(
                Tenancy::COLUMN_STATUS, [Tenancy::COLUMN_BLOCK, Tenancy::COLUMN_ACTIVE, Tenancy::COLUMN_HOP_DONG_THANH_LY]
            );

        if ($type == 'count') {
            return $result->count();
        } elseif ($type == 'excel') {
            return $result->get();
        } else {
            return $result
                ->offset((int)$offset)
                ->limit((int)$limit)
                ->orderBy(Tenancy::COLUMN_CREATED_AT, "DESC")
                ->get();
        }
    }


//theo dõi đặt cọc
    public function listDatCoc()
    {
        $result = $this->tenancyModel
        ->where([Tenancy::COLUMN_STATUS => Tenancy::COLUMN_ACTIVE])
        ->get()->toArray();
        return '';
    }

//update status
    public function updateStatus($id)
    {
        $result = $this->tenancyModel->where([Tenancy::COLUMN_ID => $id])->find($id)->toArray();
        if ($result['status'] == Tenancy::COLUMN_ACTIVE){
            $this->tenancyModel->where([Tenancy::COLUMN_ID => $id])->update([Tenancy::COLUMN_STATUS => Tenancy::COLUMN_BLOCK]);
        }else{
            $this->tenancyModel->where([Tenancy::COLUMN_ID => $id])->update([Tenancy::COLUMN_STATUS => Tenancy::COLUMN_ACTIVE]);
        }
        return $result;
    }
//ghi log thay đổi giữ liệu
    public function log($id,$action,$createdBy)
    {
        $logs = [
            'action'        => $action,
            'created_by'    => $createdBy,
            'created_at'    => time()
        ];
        $updatelog = $this->tenancyModel->where([
            Tenancy::COLUMN_ID => $id
        ])->push(Tenancy::COLUMN_LOGS,$logs);
    }

//lấy logs của từng hợp đồng

    public function find_logs($id)
    {
        $result = $this->tenancyModel->find($id)->toArray();
        if (isset($result['logs'])){
            $resultLogs = $result['logs'];
        }else{
            $resultLogs = [];
        }
        return $resultLogs;
    }

//upload scan hợp đồng

    public function upload_scan_hd($data)
    {
        $data1 = [
            Tenancy::COLUMN_IMAGE_TENANCY => $data[Tenancy::COLUMN_IMAGE_TENANCY] ?? null,
        ];
        $result_data = $this->tenancyModel
        ->where([Tenancy::COLUMN_ID => $data[Tenancy::COLUMN_ID]])
        ->update($data1);

        return $result_data;
    }
//update status ky_han

    public function updateStatusKyHan($id)
    {
        $result = $this->tenancyModel
            ->select([Tenancy::COLUMN_KY_HAN])
            ->where([
                Tenancy::COLUMN_STATUS => Tenancy::COLUMN_ACTIVE,
                Tenancy::COLUMN_ID => $id,
            ])
            ->first();
        $updateData = [];
        foreach ($result['ky_han'] as $key => $item) {
            if ($item['status_ky_han'] == "1") {
                $item['status_ky_han'] = "2";
            }
            $updateData[] = $item;
        }
        $result = $this->tenancyModel
            ->where([Tenancy::COLUMN_ID => $id])
            ->update(["ky_han" => $updateData]);
        return $result;

    }
//tìm tất cả các phụ lục của từng hợp đồng gốc
    public function find_one_appendix($id)
    {
        $ky_han = [];
        $result = $this->tenancyModel
            ->select([Tenancy::COLUMN_KY_HAN])
            ->where([Tenancy::COLUMN_ID => $id])
            ->whereIn(
                Tenancy::COLUMN_STATUS, [ Tenancy::COLUMN_ACTIVE, Tenancy::COLUMN_HOP_DONG_THANH_LY]
                )
            ->get()->toArray();
        if (!empty($result)) {
            foreach ($result as $item) {
                if ($item) {
                    $kyHan = $item["ky_han"];
                    foreach ($kyHan as $v) {
                        $ky_han[] = $v;
                    }
                }
            }
        }
        return $ky_han;
    }

//lịch sử thanh toán tiền cấn cọc

    public function historyPayMentDeposit($id)
    {
        $tien_can_coc = [];
        $result = $this->tenancyModel
            ->select([Tenancy::COLUMN_TIEN_CAN_COC])
            ->where([Tenancy::COLUMN_ID => $id])
            ->whereIn(
                Tenancy::COLUMN_STATUS, [Tenancy::COLUMN_ACTIVE, Tenancy::COLUMN_HOP_DONG_THANH_LY]
            )
            ->first();
        if (!empty($result)) {
            if (!empty($result->tien_can_coc)) {
                foreach ($result->tien_can_coc as $value) {
                    $tien_can_coc[] = $value;
                }
            }
        }
         return $tien_can_coc;
    }
//lịch sử chủ nhà thanh toán tiền cọc
    public function historyPayMentDepositHome($id)
    {
        $tien_can_coc_chu_nha = [];
        $result = $this->tenancyModel
            ->select([Tenancy::COLUMN_TIEN_COC_CHU_NHA])
            ->where([Tenancy::COLUMN_ID => $id])
            ->whereIn(
                Tenancy::COLUMN_STATUS, [Tenancy::COLUMN_ACTIVE, Tenancy::COLUMN_HOP_DONG_THANH_LY]
            )
            ->first();
        if (!empty($result)) {
            if (!empty($result->tien_coc_chu_nha)) {
                foreach ($result->tien_coc_chu_nha as $value) {
                    $tien_can_coc_chu_nha[] = $value;
                }
            }
        }
        return $tien_can_coc_chu_nha;
    }

//validate thêm mới kỳ hạn
    public function findLatsEnddate($id)
    {
        $lastTime = 0;
        $result = $this->tenancyModel
        ->select([Tenancy::COLUMN_KY_HAN])
        ->where([Tenancy::COLUMN_ID => $id])
        ->where([Tenancy::COLUMN_STATUS => Tenancy::COLUMN_ACTIVE])
        ->first();
        if (!empty($result)){
            $result = $result->toArray();
            $arr_ky_han = [];
            foreach ($result['ky_han'] as $v) {
                if ($lastTime < $v['end_date_contract_uni']) {
                    $lastTime = $v['end_date_contract_uni'];
                }
            }
        }
        return $lastTime;
    }
//update hợp đồng khi hợp đồng chưa được kích hoạt
    public function updateTenancyStatusBlock($data, $id)
    {
        $result = [];
        if (isset($data['code_contract'])) {
            $result[$this->tenancyModel::COLUMN_CODE_CONTRACT] = $data['code_contract'];
        }
        if (isset($data['date_contract'])) {
            $result[$this->tenancyModel::COLUMN_DATE_CONTRACT] = strtotime($data['date_contract']);
        }
        if (isset($data['contract_expiry_date'])) {
            $result[$this->tenancyModel::COLUMN_CONTRACT_EXPIRY_DATE] = $data['contract_expiry_date'];
        }

        if (isset($data['address'])) {
            $result[$this->tenancyModel::COLUMN_ADDRESS] = $data['address'];
        }

        if (isset($data['store_name'])) {
            $result[$this->tenancyModel::COLUMN_STORE_NAME] = $data['store_name'];
        }
        if (isset($data['name_cty'])) {
            $result[$this->tenancyModel::COLUMN_NAME_CTY] = $data['name_cty'];
        }
        if (isset($data['staff_ptmb'])) {
            $result[$this->tenancyModel::COLUMN_STAFF_PTMB] = $data['staff_ptmb'];
        }
        if (isset($data['one_month_rent'])) {
            $result[$this->tenancyModel::COLUMN_ONE_MONTH_RENT] = $data['one_month_rent'];
        }
        if (isset($data['ky_han'])) {
            $result[$this->tenancyModel::COLUMN_KY_HAN] = $data['ky_han'];
        }

        if (isset($data['ten_chu_nha'])) {
            $result[$this->tenancyModel::COLUMN_TEN_CHU_NHA] = $data['ten_chu_nha'];
        }
        if (isset($data['sdt_chu_nha'])) {
            $result[$this->tenancyModel::COLUMN_SDT_CHU_NHA] = $data['sdt_chu_nha'];
        }
        if (isset($data['ten_tk_chu_nha'])) {
            $result[$this->tenancyModel::COLUMN_TEN_TK_CHU_NHA] = $data['ten_tk_chu_nha'];
        }
        if (isset($data['so_tk_chu_nha'])) {
            $result[$this->tenancyModel::COLUMN_SO_TK_CHU_NHA] = $data['so_tk_chu_nha'];
        }
        if (isset($data['bank_name'])) {
            $result[$this->tenancyModel::COLUMN_BANK_NAME] = $data['bank_name'];
        }
        if (isset($data['tien_coc'])) {
            $result[$this->tenancyModel::COLUMN_TIEN_COC] = $data['tien_coc'];
        }
        if (isset($data['ngay_dat_coc'])) {
            $result[$this->tenancyModel::COLUMN_NGAY_DAT_COC] = strtotime($data['ngay_dat_coc']);
        }
        if (isset($data['tien_coc_thua'])) {
            $result[$this->tenancyModel::COLUMN_TIEN_COC_THUA] = $data['tien_coc_thua'];
        }
        if (isset($data['ma_so_thue'])) {
            $result[$this->tenancyModel::COLUMN_MA_SO_THUE] = $data['ma_so_thue'];
        }
        if (isset($data['nguoi_nop_thue'])) {
            $result[$this->tenancyModel::COLUMN_NGUOI_NOP_THUE] = $data['nguoi_nop_thue'];
        }
        if (isset($data['created_by'])) {
            $result[$this->tenancyModel::COLUMN_CREATED_BY] = $data['created_by'];
        }
        if (isset($data['update_by'])) {
            $result[$this->tenancyModel::COLUMN_UPDATED_BY] = $data['update_by'];
        }

        if (isset($data['ky_tra'])) {
            $result[$this->tenancyModel::COLUMN_KY_TRA] = $data['ky_tra'];
        }

        if (isset($data['start_date_contract_uni'])) {
            $result[$this->tenancyModel::COLUMN_START_DATE_CONTRACT_UNI] = strtotime($data['start_date_contract_uni']);
        }

        if (isset($data['end_date_contract_uni'])) {
            $result[$this->tenancyModel::COLUMN_END_DATE_CONTRACT_UNI] = strtotime($data['end_date_contract_uni']);
        }

        if (isset($data['start_date_contract_uni'])) {
            $result[$this->tenancyModel::COLUMN_START_DATE_CONTRACT] = date("d/m/Y",strtotime($data['start_date_contract_uni']));
        }
        if (isset($data['end_date_contract_uni'])) {
            $result[$this->tenancyModel::COLUMN_END_DATE_CONTRACT] = date("d/m/Y", strtotime($data['end_date_contract_uni']));
        }

        if (isset($data['dien_tich'])) {
            $result[$this->tenancyModel::COLUMN_DIEN_TICH] = $data['dien_tich'];
        }

        if (isset($data['tien_coc'])) {
            $result[$this->tenancyModel::COLUMN_TIEN_COC_THUA] = $data['tien_coc'];
        }

        if (empty($result)) {
            return false;
        }

        $update_tenancy = $this->tenancyModel
        ->where([Tenancy::COLUMN_STATUS => Tenancy::COLUMN_BLOCK])
        ->where([Tenancy::COLUMN_ID => $id])
        ->update($result);
        $result_ky_han = $this->tenancyModel
        ->where([Tenancy::COLUMN_STATUS => Tenancy::COLUMN_BLOCK])
        ->where([Tenancy::COLUMN_ID => $id])
        ->first()->toArray();
        $start_date_contract = $result_ky_han['start_date_contract'];
        $data2 = [
            'start_date_contract' => date("d/m/Y", strtotime($data['start_date_contract_uni'])) ?? null,
            'end_date_contract' => date("d/m/Y", strtotime($data['end_date_contract_uni'])) ?? null,
            'ky_tra' => $data['ky_tra'] ?? null,
            'contract_expiry_date' => $data['contract_expiry_date'] ?? null,
            'hop_dong_so' => 1,
            'one_month_rent' => $data['one_month_rent'] ?? null,
            'created_at' => time(),
            'status_ky_han' => "1",
            'start_date_contract_uni' => strtotime($data['start_date_contract_uni']) ?? null,
            'end_date_contract_uni' => strtotime($data['end_date_contract_uni']) ?? null,
        ];
        $resultKyHan = $this->tenancyModel->select(Tenancy::COLUMN_KY_HAN)->where([Tenancy::COLUMN_ID => $id])
        ->update(
                [Tenancy::COLUMN_KY_HAN =>[$data2]]
        );
        return $update_tenancy;
    }

//thêm ngày thanh lý hợp đồng
    public function TLHDTenancy($request,$id)
    {
        $data = [
            Tenancy::COLUMN_NGAY_THANH_LY => strtotime(trim($request->ngay_thanh_ly)."00:00:00") ?? null
        ];
        $result = $this->tenancyModel->where(Tenancy::COLUMN_ID,$id)->update($data);
        return $result;
    }
//lấy hết tất cả các hợp đồng tồn tại ngày thanh lý
    public function getAllTenancyHDTL()
    {
        $curentTime = time();
        $curent_time =  strtotime(date("Y-m-d",$curentTime). "00:00:00");
        $result = $this->tenancyModel
            ->where
            ([
                Tenancy::COLUMN_NGAY_THANH_LY => $curent_time,
                Tenancy::COLUMN_STATUS => Tenancy::COLUMN_ACTIVE
            ])
        ->get()->toArray();
        return $result;
    }

}
