<?php

namespace Modules\MysqlCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MysqlCore\Entities\Reconciliation;
use Modules\MysqlCore\Repositories\Interfaces\ReconciliationRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;

class ReconciliationRepository implements ReconciliationRepositoryInterface
{

    /**      
     * @var Model      
     */     
     protected $reconciliationModel;

    /**
     * ReconciliationRepository constructor.
     *
     * @param Reconciliation $reconciliation
     */
    public function __construct(Reconciliation $reconciliation) {
        $this->reconciliationModel = $reconciliation;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function store($attributes) {
        $dataSave = [];
        $dataSave[$this->reconciliationModel::CODE] = $this->setCode();
        $dataSave[$this->reconciliationModel::PAY_AMOUNT] = (int)$attributes["totalPaidAmount"];
        $dataSave[$this->reconciliationModel::CREATED_BY] = !empty($attributes["created_by"]) ? $attributes["created_by"] : "";
        $dataSave[$this->reconciliationModel::UPDATED_BY] = !empty($attributes["created_by"]) ? $attributes["created_by"] : "";
        Log::info('transactions reconciliation dataSave: ' . print_r($attributes, true));
        $reconciliation = $this->reconciliationModel->create($dataSave);
        return $reconciliation;
    }

    /**
     * Find the specified esource in storage.
     *
     * @param  int  $id
     * @return Collection
     */
    public function find($id) {
        $selectStatusText = $this->querySelectStatus();
        $reconciliation = $this->reconciliationModel::select(DB::raw(
            "*, " . $selectStatusText
        ))->findOrFail($id);
        return $reconciliation->toArray();
    }

    /**
     * Soft delete the specified esource in storage.
     *
     * @param  int  $id
     * @return Collection
     */
    public function delete($id) {
        $reconciliation = $this->reconciliationModel::findOrFail($id);
        return $reconciliation->delete();
    }

    protected function setCode() {
        $today = new DateTime();
        return 'MT' . $today->format('d') . $today->format('m') . $today->format('y');
    }

    /**
     * Find all element in storage.
     *
     * @param  int  $id
     * @return Collection
     */
    public function all() {
        $selectStatusText = $this->querySelectStatus();
        $reconciliations = $this->reconciliationModel::select(DB::raw(
            "*, " . $selectStatusText
        ))->get();
        return $reconciliations;
    }

    /**
     * @param $time fomat yyyy-mm-dd
     * get list by month
     * @return collection
     */
    public function getListByMonth($time) {
        $selectStatusText = $this->querySelectStatus();
        // First day of the month.
        $startDate =  date('Y-m-01 00:00:00', strtotime($time));
        // Last day of the month.
        $endDate = date('Y-m-t 23:59:59', strtotime($time));

        $select = DB::raw(
            "*, " . $selectStatusText
        );
        $reconciliations = $this->reconciliationModel::select($select)
        ->whereBetween(
            $this->reconciliationModel::CREATED_AT, [$startDate, $endDate]
        )->get();
        $totalPayAmount = $reconciliations->sum($this->reconciliationModel::PAY_AMOUNT);
        $totalPaidAmount = $reconciliations->sum($this->reconciliationModel::PAID_AMOUNT);
        $remainingAmount = $totalPayAmount - $totalPaidAmount;
        $result = [
            'totalPayAmount' => number_format($totalPayAmount),
            'totalPaidAmount' => number_format($totalPaidAmount),
            'remainingAmount' => number_format(($remainingAmount > 0) ? $remainingAmount : 0),
            'data' => $reconciliations
        ];
        return $result;
    }

    protected function querySelectStatus() {
        $select = "(CASE 
                WHEN status = '". $this->reconciliationModel::STATUS_NOTSENDEMAIL . "' THEN 'Chưa gửi email'
                WHEN status = '". $this->reconciliationModel::STATUS_SENDEMAIL . "' THEN 'Đang gửi email'
                WHEN status = '". $this->reconciliationModel::STATUS_PENDING . "' THEN 'Chờ nhận tiền'
                WHEN status = '". $this->reconciliationModel::STATUS_SUCCESS . "' THEN 'Đã nhận đủ tiền'
                WHEN status = '". $this->reconciliationModel::STATUS_UNDERPAYMENT . "' THEN 'Nhận thiếu tiền'
                WHEN status = '". $this->reconciliationModel::STATUS_OVERPAYMENT . "' THEN 'Nhận thừa tiền'
                ELSE 'Không xác định'
            END) AS status_text, " . $this->reconciliationModel::CREATED_AT . " as created_at_fomated";
        return $select;
    }

    public function sendingEmailStatus($id) {
        $reconciliation = $this->reconciliationModel::findOrFail($id);
        if ($reconciliation) {
            $reconciliation->update([$this->reconciliationModel::STATUS => $this->reconciliationModel::STATUS_SENDEMAIL]);
            return true;
        }
        return false;
    }
}
