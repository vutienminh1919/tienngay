<?php


namespace App\Repository;


use App\Models\Contract;
use App\Models\Pay;
use Illuminate\Support\Facades\DB;

class PayRepository extends BaseRepository implements PayRepositoryInterface
{
    public function getModel()
    {
        return Pay::class;
    }

    public function get_all_pay_paginate($condition)
    {
        $query = $this->search_overview_pay($condition);
        $query = $query
            ->orderBy(Pay::COLUMN_NGAY_KY_TRA, self::DESC)
            ->paginate(20);
        return $query;
    }

    public function total_pay($condition)
    {
        $query = $this->search_overview_pay_v2($condition);
        return $query
            ->count();
    }

    public function total_money_pay($condition)
    {
        $query = $this->search_overview_pay_v2($condition);
        return $query
            ->sum('pay.goc_lai_1ky');
    }

    public function tong_ky_chua_tra($condition)
    {
        $query = $this->search_overview_pay_v2($condition);
        return $query
            ->where('pay.status', Pay::CHUA_THANH_TOAN)
            ->count();
    }

    public function tong_tien_ki_chua_tra($condition)
    {
        $query = $this->search_overview_pay_v2($condition);
        return $query
            ->where('pay.status', Pay::CHUA_THANH_TOAN)
            ->sum('pay.goc_lai_1ky');
    }

    public function tong_ky_da_tra($condition)
    {
        $query = $this->search_overview_pay_v2($condition);
        return $query
            ->where('pay.status', Pay::DA_THANH_TOAN)
            ->count();
    }

    public function tong_tien_ki_da_tra($condition)
    {
        $query = $this->search_overview_pay_v2($condition);
        return $query
            ->where("pay.status", Pay::DA_THANH_TOAN)
            ->sum('pay.goc_lai_1ky');
    }

    public function tong_ky_den_han_tra($condition)
    {
        $start = strtotime(date('Y-m-d 00:00:00', time()));
        $end = strtotime(date('Y-m-d 23:59:59', time()));
        $query = $this->search_overview_pay_v2($condition);
        return $query
            ->whereIn('pay.status', [Pay::CHUA_THANH_TOAN, Pay::THANH_TOAN_TU_DONG_THAT_BAI])
            ->whereBetween('pay.ngay_ky_tra', [$start, $end])
            ->count();
    }

    public function tong_tien_ky_den_han_tra($condition)
    {
        $start = strtotime(date('Y-m-d 00:00:00', time()));
        $end = strtotime(date('Y-m-d 23:59:59', time()));
        $query = $this->search_overview_pay_v2($condition);
        return $query
            ->whereIn('pay.status', [Pay::CHUA_THANH_TOAN, Pay::THANH_TOAN_TU_DONG_THAT_BAI])
            ->whereBetween('pay.ngay_ky_tra', [$start, $end])
            ->sum('pay.goc_lai_1ky');
    }

    public function findPayTimeToNow($contractId, $time)
    {
        return $this->model
            ->where(Pay::COLUMN_CONTRACT_ID, $contractId)
            ->where(Pay::COLUMN_NGAY_KY_TRA, '<=', strtotime($time))
            ->where(Pay::COLUMN_STATUS, Pay::CHUA_THANH_TOAN)
            ->get();
    }

    public function tong_tien_lai_hop_dong($contract_id)
    {
        $query = $this->model;
        $query = $query->whereHas('contract', function ($query_contract) use ($contract_id) {
            $query_contract->where(Contract::COLUMN_ID, $contract_id);
        });
        return $query->sum(Pay::COLUMN_TIEN_LAI_1KY_PHAI_TRA);
    }

    public function danh_sach_thanh_toan_tu_dong()
    {
        $start = strtotime(date('Y-m-d 00:00:00', time()));
        $end = strtotime(date('Y-m-d 23:59:59', time()));
        $query = $this->model;
        $query = $query->whereIn(Pay::COLUMN_STATUS, [Pay::CHUA_THANH_TOAN, Pay::THANH_TOAN_NGAN_LUONG_THAT_BAI])
            ->whereBetween(Pay::COLUMN_NGAY_KY_TRA, [$start, $end]);
        $query = $query->whereHas('contract', function ($query_contract) {
            $query_contract->where(Contract::COLUMN_TYPE_CONTRACT, Contract::HOP_DONG_DAU_TU_APP);
        });
        return $query->get();
    }

    public function lay_ki_tra_theo_ngay($date)
    {
        $time = strtotime($date);
        $start = strtotime(date('Y-m-d 00:00:00', $time));
        $end = strtotime(date('Y-m-d 23:59:59', $time));
        $query = $this->model;
        $query = $query->whereIn(Pay::COLUMN_STATUS, [Pay::CHUA_THANH_TOAN, Pay::THANH_TOAN_TU_DONG_THAT_BAI])
            ->whereBetween(Pay::COLUMN_NGAY_KY_TRA, [$start, $end]);
        $query = $query->whereHas('contract', function ($query_contract) {
            $query_contract->where(Contract::COLUMN_TYPE_CONTRACT, Contract::HOP_DONG_DAU_TU_APP);
        });
        return $query->get();
    }

    public function get_all_pay_app($condition)
    {
        $query = $this->search_overview_pay($condition);
        $query = $query
            ->orderBy(Pay::COLUMN_NGAY_KY_TRA, self::DESC)
            ->get();
        return $query;
    }

    public function dashboard_investor($investor_id, $column, $type = [])
    {
        $model = $this->model;
        $model = $model->whereHas('contract', function ($query) use ($investor_id) {
            $query->where(Contract::COLUMN_INVESTOR_ID, $investor_id);
        });
        return $model
            ->whereIn(Pay::COLUMN_STATUS, $type)
            ->sum($column);
    }

    public function get_pay_not_payment($contract_id)
    {
        $model = $this->model;
        $model = $model
            ->where(Pay::COLUMN_CONTRACT_ID, $contract_id)
            ->whereIn(Pay::COLUMN_STATUS, [1, 3, 4, 5, 6])
            ->get();
        return $model;
    }

    public function get_all_pay_app_v2($condition)
    {
        $query = $this->search_overview_pay_v2($condition);
        $query = $query->selectRaw('
            CASE
                 WHEN DATEDIFF(FROM_UNIXTIME(pay.interest_period), FROM_UNIXTIME(contract.due_date)) < 1 THEN "true"
                 ELSE "false"
            END AS ky_cuoi
            ');
        if (!empty($condition['excel']) && $condition['excel'] == true) {
            $query = $query
                ->orderBy(Pay::COLUMN_NGAY_KY_TRA, self::DESC)
                ->get();
        } else {
            $query = $query
                ->orderBy(Pay::COLUMN_NGAY_KY_TRA, self::DESC)
                ->paginate(30);
        }
        return $query;
    }

    public function tong_tien_lai_hop_dong_v2($contract_id)
    {
        $tong_lai = DB::table('pay')
            ->select(DB::raw('sum(tien_lai_1ky_phai_tra) as tong_tien_lai'))
            ->where(Pay::COLUMN_CONTRACT_ID, $contract_id)
            ->first();
        return $tong_lai;
    }

    public function getALlActive_v2($investor_id)
    {
        $query = DB::table('contract')
            ->where('contract.investor_id', $investor_id)
            ->where('contract.type_contract', Contract::HOP_DONG_DAU_TU_APP)
            ->where('contract.status_contract', Contract::EFFECT)
            ->join('pay', 'contract.id', '=', 'pay.contract_id')
            ->where('pay.status', Pay::CHUA_THANH_TOAN)
            ->sum('pay.tien_goc_1ky');
        return $query;
    }
}
