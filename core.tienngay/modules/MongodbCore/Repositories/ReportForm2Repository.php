<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\ReportForm2;
use Modules\MongodbCore\Repositories\Interfaces\ReportForm2RepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;

class ReportForm2Repository implements ReportForm2RepositoryInterface
{

    /**      
     * @var Model      
     */     
     protected $rpModel;

    /**
     * ReportForm2Repository constructor.
     *
     * @param ReportForm2 $rpModel
     */
    public function __construct(ReportForm2 $rpModel) {
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
            $query->where(ReportForm2::NGAY_THANH_TOAN, '>=', strtotime($startDate));
            $query->where(ReportForm2::NGAY_THANH_TOAN, '<=', strtotime($endDate));
        })->orderBy(ReportForm2::NGAY_THANH_TOAN, 'desc')->get();
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
            $searchArr[] = [ReportForm2::MA_PHIEU_GHI, '=', trim($conditions['contract_code'])];
        }
        if(!empty($conditions['contract_disbursement'])) {
            $searchArr[] = [ReportForm2::MA_HOP_DONG, '=', trim($conditions['contract_disbursement'])];
        }
        $reports = $this->rpModel::where($searchArr);
        if(!empty($conditions['range_time'])) {
            $startDate =  date('Y-m-01 00:00:00', strtotime($conditions['range_time']));
            // Last day of the month.
            $endDate = date('Y-m-t 23:59:59', strtotime($conditions['range_time']));
            $reports = $reports->where(function ($query) use ($startDate, $endDate) {
                $query->where(ReportForm2::NGAY_THANH_TOAN, '>=', strtotime($startDate));
                $query->where(ReportForm2::NGAY_THANH_TOAN, '<=', strtotime($endDate));
            });
        }
        if ($reports->count() > 0) {
            return $reports->orderBy(ReportForm2::NGAY_THANH_TOAN, 'desc')->get();
        }
        return [];
    }
}
