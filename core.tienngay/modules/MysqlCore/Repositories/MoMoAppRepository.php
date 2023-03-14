<?php

namespace Modules\MysqlCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MysqlCore\Entities\MoMoApp;
use Modules\MysqlCore\Repositories\Interfaces\MoMoAppRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MoMoAppRepository implements MoMoAppRepositoryInterface
{

    /**      
     * @var Model      
     */     
     protected $momoAppModel;

    /**
     * MoMoAppRepository constructor.
     *
     * @param MoMoApp $momoApp
     */
    public function __construct(MoMoApp $momoApp) {
        $this->momoAppModel = $momoApp;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function store($attributes) {
        $transaction = $this->momoAppModel->create($attributes);
        return $transaction;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  array $attributes
     * @param  int  $id
     * @return boolean
     */
    public function update($attributes, $id) {
        $transaction = $this->momoAppModel->findOrFail($id);
        if ($transaction && $transaction[$this->momoAppModel::TOTAL_AMOUNT] > $attributes['amount']) {
            Log::info('Số tiền thanh toán không hợp lệ');
            return false; // số tiền thanh toán không hợp lệ
        }
        if ($transaction && !$transaction[$this->momoAppModel::TRANSACTIONID]) {
            $transaction[$this->momoAppModel::REQUEST_NOTIFY_PAYMENT] = $attributes['requestId'];
            $transaction[$this->momoAppModel::TRANSACTIONID] = $attributes['transactionId'];
            $transaction[$this->momoAppModel::PAID_AMOUNT] = $attributes['amount'];
            $transaction[$this->momoAppModel::PAID_DATE] = $attributes['date'];
            $transaction[$this->momoAppModel::TRANSACTION_FEE] = $attributes['transaction_fee'];
            $transaction[$this->momoAppModel::STATUS] = $this->momoAppModel::TRANSACTION_SUCCESS;
            if ($transaction->save()) {
                return $transaction;
            } else {
                Log::info('Error: Cập nhật dữ liệu thất bại.');
                return false;
            }
        }
        Log::info('Error: Giao dịch đã được thanh toán trước đó.');
        return false;
        
    }

    /**
     * Update contract_transaction_id.
     *
     * @param  array $attributes
     * @param  int  $id
     * @return boolean
     */
    public function updateContractTransactionId($attributes, $id) {
        $transaction = $this->momoAppModel->findOrFail($id);
        if ($transaction) {
            $transaction[$this->momoAppModel::CONTRACT_TRANSACTION_ID] = $attributes['contract_transaction_id'];
            $transaction[$this->momoAppModel::CONTRACT_STATUS] = $attributes['contract_status'];
            if ($transaction->save()) {
                return $transaction;
            } else {
                return false;
            }
        }

        return false;
        
    }

    /**
     * get all transaction
     * @return collection
     */
    public function all() {
        $transactions = $this->momoAppModel::get();
        return $transactions;
    }

    /**
     * @param $time fomat yyyy-mm-dd
     * get transaction by month
     * @return collection
     */
    public function getListByMonth($time) {

        // First day of the month.
        $startDate =  date('Y-m-01 00:00:00', strtotime($time));
        // Last day of the month.
        $endDate = date('Y-m-t 23:59:59', strtotime($time));

        $transactions = $this->momoAppModel::whereBetween(
            $this->momoAppModel::CREATED_AT, [$startDate, $endDate]
        )->where(
            $this->momoAppModel::STATUS, $this->momoAppModel::TRANSACTION_SUCCESS
        )->get();
        $result = [
            'totalPaidAmount' => number_format($transactions->sum('paid_amount')),
            'totalTransactionFee' => number_format($transactions->sum('transaction_fee')),
            'totalTransaction' => number_format(count($transactions)),
            'data' => $transactions
        ];
        return $result;
    }

    /**
     * Find the specified esource in storage.
     *
     * @param  int  $id
     * @return Collection
     */
    public function find($id) {
        try {
            $transaction = $this->momoAppModel::findOrFail((int)$id);
            if (!$transaction) {
                return false;
            }
            $transaction->contract_status_text = $this->momoAppModel::getContractStatusText($transaction->contract_status);
            $transaction->status_text = $this->momoAppModel::getStatusText($transaction->status);
            $transaction->payment_option_text = $this->momoAppModel::getPaymentOptionText($transaction->payment_option);
            return $transaction;
        } catch(ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * Find the specified esource in storage.
     *
     * @param  Array  $condition
     * @return Collection
     */
    public function searchByConditions($conditions) {
        $searchArr = [];
        if(!empty($conditions['contract_status'])) {
            $searchArr[] = [$this->momoAppModel::CONTRACT_STATUS, '=', $conditions['contract_status']];
        }
        if(!empty($conditions['contract_code_disbursement'])) {
            $searchArr[] = [$this->momoAppModel::CONTRACT_CODE_DISBURSEMENT, 'LIKE', '%' . trim($conditions['contract_code_disbursement']) . '%'];
        }
        if(!empty($conditions['contract_transaction_id'])) {
            $searchArr[] = [$this->momoAppModel::CONTRACT_TRANSACTION_ID, 'LIKE', '%' . trim($conditions['contract_transaction_id']) . '%'];
        }
        if(!empty($conditions['transactionId'])) {
            $searchArr[] = [$this->momoAppModel::TRANSACTIONID, 'LIKE', '%' . trim($conditions['transactionId']) . '%'];
        }

        if(!empty($conditions['start_date'])) {
            $startDate =  date('Y-m-d 00:00:00', strtotime($conditions['start_date']));
            $searchArr[] = [$this->momoAppModel::CREATED_AT, '>=', trim($startDate)];
        }
        if(!empty($conditions['end_date'])) {
            $endDate =  date('Y-m-d 23:59:59', strtotime($conditions['end_date']));
            $searchArr[] = [$this->momoAppModel::CREATED_AT, '<=', trim($endDate)];
        }
        if(!empty($conditions['status'])) {
            $searchArr[] = [$this->momoAppModel::STATUS, '=', trim($conditions['status'])];
        }
        if(!empty($conditions['confirmed'])) {
            $searchArr[] = [$this->momoAppModel::CONFIRMED, '=', trim($conditions['confirmed'])];
        }
        if(!empty($conditions['contract_code'])) {
            $searchArr[] = [$this->momoAppModel::CONTRACT_CODE, '=', trim($conditions['contract_code'])];
        }
        if(!empty($conditions['payment_option'])) {
            $searchArr[] = [$this->momoAppModel::PAYMENT_OPTION, '=', $conditions['payment_option']];
        }
        DB::enableQueryLog();
        if (empty($searchArr)) {
            $transactions = $this->momoAppModel::all();
        } else {
            $transactions = $this->momoAppModel::where(function ($query) use ($searchArr) {
                $query->where($searchArr);
            })
            ->get();
        }
        $result = [
            'totalPaidAmount' => number_format($transactions->sum('paid_amount')),
            'totalTransactionFee' => number_format($transactions->sum('transaction_fee')),
            'totalTransaction' => number_format(count($transactions)),
            'data' => $transactions
        ];
        return $result;
    }

    /**
     * @param $id epayment_transaction ids
     * get transaction by multiple ids
     * @return collection
     */
    public function summaryNotReconciliationByIds($ids) {

        $transactions = $this->momoAppModel::whereNull(
            $this->momoAppModel::TRANSACTION_RECONCILIATION_ID
        )->where(
            $this->momoAppModel::STATUS, $this->momoAppModel::TRANSACTION_SUCCESS
        )->whereIn('id', $ids)->get();
        $result = [
            'totalPaidAmount' => $transactions->sum('paid_amount'),
            'totalTransactionFee' => $transactions->sum('transaction_fee'),
            'totalTransaction' => count($transactions),
            'data' => $transactions
        ];
        return $result;
    }

    /**
     * @param $time fomat yyyy-mm-dd
     * update Reconciliation id
     * @return collection
     */
    public function updateReconciliationId($reconciliationId, $transactionIds) {

        $result = $this->momoAppModel::whereNull(
            $this->momoAppModel::TRANSACTION_RECONCILIATION_ID
        )->where(
            $this->momoAppModel::STATUS, $this->momoAppModel::TRANSACTION_SUCCESS
        )->whereIn('id', $transactionIds)
        ->update([
            $this->momoAppModel::TRANSACTION_RECONCILIATION_ID => $reconciliationId,
            $this->momoAppModel::CONFIRMED => $this->momoAppModel::CONFIRMED_SUCCESS,
        ]);
        return $result;
    }

    /**
     * Check contract has transaction which is in process
     * @param $contractTransactionId
     * @return int
     */
    public function checkTransactionInProcess($contractId) {

        $result = $this->momoAppModel::where(
            $this->momoAppModel::CONTRACT_ID, $contractId
        )->where(
            $this->momoAppModel::CONTRACT_STATUS, $this->momoAppModel::CONTRACT_STATUS_PENDING
        )->where(
            $this->momoAppModel::STATUS, $this->momoAppModel::TRANSACTION_SUCCESS
        )->get();
        return $result->count();
    }

    /**
     * Check contract has been complated
     * @param $contractTransactionId
     * @return boolean
     */
    public function isComplatedContract($contractId) {

        $result = $this->momoAppModel::where(
            $this->momoAppModel::CONTRACT_ID, $contractId
        )->where(
            $this->momoAppModel::PAYMENT_OPTION, $this->momoAppModel::PAYMENT_OPTION_FINAL
        )->where(
            $this->momoAppModel::STATUS, $this->momoAppModel::TRANSACTION_SUCCESS
        )->get();
        if( $result->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Check contract has transaction which is in process
     * @param $contractTransactionId
     * @return int
     */
    public function getTransactionsByReconciliationId($reconciliationId) {
        $select = DB::raw(
            "*, " . $this->querySelectStatus()
        );
        $transactions = $this->momoAppModel::select($select)
        ->where(
            $this->momoAppModel::TRANSACTION_RECONCILIATION_ID, $reconciliationId
        )
        ->get();
        $result = [
            'totalPaidAmount' => number_format($transactions->sum('paid_amount')),
            'totalTransactionFee' => number_format($transactions->sum('transaction_fee')),
            'totalTransaction' => number_format(count($transactions)),
            'data' => $transactions->toArray()
        ];
        return $result;
    }

    public function removeReconciliationId($reconciliationId) {
        $result = $this->momoAppModel::where(
            $this->momoAppModel::TRANSACTION_RECONCILIATION_ID, $reconciliationId
        )
        ->update([
            $this->momoAppModel::TRANSACTION_RECONCILIATION_ID => null,
            $this->momoAppModel::CONFIRMED => $this->momoAppModel::CONFIRMED_PENDING,
        ]);
        return $result;
    }

    protected function querySelectStatus() {
        $select = "(CASE 
                WHEN status = '". $this->momoAppModel::TRANSACTION_PENDING . "' THEN 'Chưa thanh toán'
                WHEN status = '". $this->momoAppModel::TRANSACTION_SUCCESS . "' THEN 'Đã thanh toán'
                ELSE 'Không xác định'
            END) AS status_text";
        return $select;
    }

    /**
     * Find the specified esource in storage.
     *
     * @param  int  Momo TransactionId
     * @return boolean true: transaction has been done!, false: not done.
     */
    public function isStatusSuccess($transactionId) {
        $transaction = $this->momoAppModel::where($this->momoAppModel::TRANSACTIONID, '=', $transactionId)->first();
        
        if($transaction && $transaction[$this->momoAppModel::STATUS] == $this->momoAppModel::TRANSACTION_SUCCESS) {
            return true;
        }

        return false;
    }

    /**
     * confirm transactions.
     *
     * @param  Array $ids
     * @return Collection
     */
    public function autoConfirm($ids) {
        $result = $this->momoAppModel::whereIn('id', $ids)
        ->update([
            $this->momoAppModel::CONFIRMED => $this->momoAppModel::CONFIRMED_SUCCESS,
        ]);
        return $result;
    }
}
