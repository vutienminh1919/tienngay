<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\ReportForm23;
use Modules\MongodbCore\Repositories\Interfaces\ReportForm23RepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;

class ReportForm23Repository implements ReportForm23RepositoryInterface
{

    /**      
     * @var Model      
     */     
     protected $rpModel;

    /**
     * ReportForm23Repository constructor.
     *
     * @param ReportForm23 $rpModel
     */
    public function __construct(ReportForm23 $rpModel) {
        $this->rpModel = $rpModel;
    }

    /**
     * @param $time fomat yyyy-mm-dd
     * get list by month
     * @return collection
     */
    public function getListByMonth($time) {
        // First day of the month.
        $startDate =  date('Y-m-01 00:00:00', strtotime($time));
        // Last day of the month.
        $endDate = date('Y-m-t 23:59:59', strtotime($time));
        $reports = $this->rpModel::where(function ($query) use ($startDate, $endDate) {
            $query->where(ReportForm23::THANG_BAO_CAO, '>=', strtotime($startDate));
            $query->where(ReportForm23::THANG_BAO_CAO, '<=', strtotime($endDate));
        })->get();
        $result = [
            'total' => number_format($reports->count()),
            'data' => $reports
        ];
        return $result;
    }

    /**
     * @param $conditions Array
     * get list by conditions
     * @return collection
     */
    public function search($conditions) {
        if (empty($conditions)) {
            return [];
        }
        $searchArr = [];
        if(!empty($conditions['contract_code'])) {
            $searchArr[] = [ReportForm23::MA_PHIEU_GHI, '=', trim($conditions['contract_code'])];
        }
        if(!empty($conditions['contract_disbursement'])) {
            $searchArr[] = [ReportForm23::MA_HOP_DONG, '=', trim($conditions['contract_disbursement'])];
        }

        if(!empty($conditions['store_id'])) {
            $searchArr[] = [ReportForm23::STORE_ID, '=', trim($conditions['store_id'])];
        }
        $reports = $this->rpModel::where($searchArr);
        if(!empty($conditions['range_time'])) {
            $startDate =  date('Y-m-01 00:00:00', strtotime($conditions['range_time']));
            // Last day of the month.
            $endDate = date('Y-m-t 23:59:59', strtotime($conditions['range_time']));

            $reports = $reports->where(function ($query) use ($startDate, $endDate) {
                $query->where(ReportForm23::THANG_BAO_CAO, '>=', strtotime($startDate));
                $query->where(ReportForm23::THANG_BAO_CAO, '<=', strtotime($endDate));
            });
        }
        if ($reports->count() > 0) {
            return $reports->get();
        }
        return [];
    }

    /**
     * @param Array $value
     * update data
     * @return collection
     */
    public function importNgayDungTinhLai($value) {
        $update = [
            ReportForm23::FLAG_DUNG_TINH_LAI => !empty($value['flag_dung_tinh_lai']) ? $value['flag_dung_tinh_lai'] : "",
            ReportForm23::NGAY_DUNG_TINH_LAI => !empty($value['ngay_dung_tinh_lai']) ? (date('d/m/Y', strtotime($value['ngay_dung_tinh_lai']))) : ""
        ];
        $result = $this->rpModel::where(ReportForm23::MA_PHIEU_GHI, '00000' . (int)$value['ma_phieu_ghi'])->update($update);
        $this->wlog('00000' . (int)$value['ma_phieu_ghi'], "update ngày dừng tính lãi", $value['created_by']);
    }

    /**
    * Write user's log
    * @param $id String: reportsksnb collection's Id
    * @param $action String: user's action
    * @param $createdby String: login user
    */
    public function wlog($maPhieuGhi, $action, $createdBy) {
        $log = [
            'action'        => $action,
            'created_by'    => $createdBy,
            'created_at'    => time()
        ];
        $updateReport = $this->rpModel::where(ReportForm23::MA_PHIEU_GHI, $maPhieuGhi)
            ->push(ReportForm23::COLUMN_LOGS, $log);
    }

}
