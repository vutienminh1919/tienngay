<?php

namespace Modules\MysqlCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MysqlCore\Entities\MistakenVpbankTransaction as TranModel;
use Modules\MysqlCore\Entities\VPBankTransaction;
use Modules\MongodbCore\Entities\Store as StoreModel;
use Modules\MysqlCore\Repositories\Interfaces\MistakenVpbankTransactionRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Str;

class MistakenVpbankTransactionRepository implements MistakenVpbankTransactionRepositoryInterface
{

    /**
     * @var Model
     */
     protected $vpbTranModel;

    /**
     * VPBankTransactionRepository constructor.
     *
     * @param VPBankTransaction $vpbTran
     */
    public function __construct(TranModel $vpbTran, StoreModel $store) {
        $this->vpbTranModel = $vpbTran;
        $this->storeModel = $store;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function store($attributes) {
        $transaction = $this->vpbTranModel->create($attributes);
        return $transaction;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function find($id) {
        $select = DB::raw(
            "mistaken_vpbank_transactions.*, vpbank_transactions.store_name, vpbank_transactions.amount, vpbank_transactions.transactionId, vpbank_transactions.transactionDate, " . $this->queryLoaiThanhToan()
            . ', ' . $this->querySelectStatus()
        );
        $transaction = $this->vpbTranModel->select($select)
        ->leftJoin('vpbank_transactions', 'vpbank_transactions.tn_trancode', '=', 'mistaken_vpbank_transactions.tn_trancode')
        ->whereNull('vpbank_transactions.' . VPBankTransaction::DELETED_AT) // not include trashed
        ->find($id);
        return $transaction;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function findByTranctionId($transactionId) {
        $select = DB::raw(
            "mistaken_vpbank_transactions.*, vpbank_transactions.store_name, vpbank_transactions.amount, vpbank_transactions.transactionId, vpbank_transactions.transactionDate, " . $this->queryLoaiThanhToan()
            . ', ' . $this->querySelectStatus()
        );
        $transaction = $this->vpbTranModel->select($select)
        ->leftJoin('vpbank_transactions', 'vpbank_transactions.tn_trancode', '=', 'mistaken_vpbank_transactions.tn_trancode')
        ->whereNull('vpbank_transactions.' . VPBankTransaction::DELETED_AT) // not include trashed
        ->where('vpbank_transactions.' . VPBankTransaction::TRANSACTION_ID, $transactionId)->first();
        return $transaction;
    }

    /**
     * @param $time fomat yyyy-mm-dd
     * get transaction by month
     * @return collection
     */
    public function getListByMonth($time) {
        $select = DB::raw(
            "mistaken_vpbank_transactions.*, vpbank_transactions.amount, vpbank_transactions.transactionId, vpbank_transactions.transactionDate, " . $this->queryLoaiThanhToan()
            . ', ' . $this->querySelectStatus()
        );
        // First day of the month.
        $startDate =  date('Y-m-01 00:00:00', strtotime($time));
        // Last day of the month.
        $endDate = date('Y-m-t 23:59:59', strtotime($time));
        $transactions = $this->vpbTranModel->select($select)
        ->leftJoin('vpbank_transactions', 'vpbank_transactions.tn_trancode', '=', 'mistaken_vpbank_transactions.tn_trancode')
        ->whereNull('vpbank_transactions.' . VPBankTransaction::DELETED_AT) // not include trashed
        ->whereBetween(
            'vpbank_transactions.'. VPBankTransaction::TRANSACTION_DATE, [$startDate, $endDate]
        )->get();
        $result = [
            'totalAmount' => number_format($transactions->sum(VPBankTransaction::AMOUNT)),
            'totalTransaction' => number_format($transactions->count()),
            'data' => $transactions
        ];
        return $result;
    }

    /**
     * Find the specified esource in storage.
     *
     * @param  Array  $condition
     * @return Collection
     */
    public function searchByConditions($conditions) {

        $select = DB::raw(
            "mistaken_vpbank_transactions.*, vpbank_transactions.amount, vpbank_transactions.transactionId, vpbank_transactions.transactionDate, " . $this->queryLoaiThanhToan()
            . ', ' . $this->querySelectStatus()
        );
        unset($conditions['_token']);
        if (empty($conditions)) {
            $transactions = DB::table('mistaken_vpbank_transactions')
            ->select($select)
            ->leftJoin('vpbank_transactions', 'vpbank_transactions.tn_trancode', '=', 'mistaken_vpbank_transactions.tn_trancode')
            ->whereNull('vpbank_transactions.' . VPBankTransaction::DELETED_AT); // not include trashed
            $transactions = $transactions->orderBy('vpbank_transactions.'. VPBankTransaction::TRANSACTION_DATE, 'DESC')->limit(3000)->get();
            $emptyAutoTrans = DB::table('vpbank_transactions')
            ->select('amount', 'transactionId', 'transactionDate', DB::raw(" 'Chưa tạo phiếu thu' AS approve_note"))
            ->where(VPBankTransaction::VIRTUAL_ACCOUNT_NUMBER, '!=', '')
            ->whereNull(VPBankTransaction::TN_TRANCODE)
            ->whereNull(VPBankTransaction::DELETED_AT)
            ->limit(3000)
            ->get();

            if ($emptyAutoTrans->count() > 0 && $transactions->count() > 0) {
                $transactions = $transactions->merge($emptyAutoTrans);
                $result = [
                    'totalAmount' => number_format($transactions->sum(VPBankTransaction::AMOUNT)),
                    'totalTransaction' => number_format($transactions->count()),
                    'data' => $transactions
                ];
            } else if ($emptyAutoTrans->count() > 0) {
                $result = [
                    'totalAmount' => number_format($emptyAutoTrans->sum(VPBankTransaction::AMOUNT)),
                    'totalTransaction' => number_format($emptyAutoTrans->count()),
                    'data' => $emptyAutoTrans
                ];
            } else {
                $result = [
                    'totalAmount' => number_format($transactions->sum(VPBankTransaction::AMOUNT)),
                    'totalTransaction' => number_format($transactions->count()),
                    'data' => $transactions
                ];
            }
            return $result;
        }
        $searchArr = [];
        $searchEmptyTrans = [];
        if(!empty($conditions['transactionId'])) {
            $searchArr[] = ['vpbank_transactions.'.VPBankTransaction::TRANSACTION_ID, '=', trim($conditions['transactionId'])];
            $searchEmptyTrans[] = [VPBankTransaction::TRANSACTION_ID, '=', trim($conditions['transactionId'])];
        }

        if(!empty($conditions['start_date'])) {
            $startDate =  date('Y-m-d 00:00:00', strtotime($conditions['start_date']));
            $searchArr[] = ['vpbank_transactions.'. VPBankTransaction::TRANSACTION_DATE, '>=', trim($startDate)];
            $searchEmptyTrans[] = [VPBankTransaction::TRANSACTION_DATE, '>=', trim($startDate)];
        }
        if(!empty($conditions['end_date'])) {
            $endDate =  date('Y-m-d 23:59:59', strtotime($conditions['end_date']));
            $searchArr[] = ['vpbank_transactions.'. VPBankTransaction::TRANSACTION_DATE, '<=', trim($endDate)];
            $searchEmptyTrans[] = [VPBankTransaction::TRANSACTION_DATE, '<=', trim($endDate)];
        }
        if(!empty($conditions['contract_code'])) {
            $searchArr[] = ['mistaken_vpbank_transactions.' . $this->vpbTranModel::CONTRACT_CODE, '=', trim($conditions['contract_code'])];
        }
        if(!empty($conditions['status'])) {
            $searchArr[] = ['mistaken_vpbank_transactions.'.$this->vpbTranModel::STATUS, '=', trim($conditions['status'])];
        }
        if(!empty($conditions['contract_disbursement'])) {
            $searchArr[] = ['mistaken_vpbank_transactions.'.$this->vpbTranModel::CODE_CONTRACT_DISBURSEMENT, '=', trim($conditions['contract_disbursement'])];
        }
        if(!empty($conditions['tn_trancode'])) {
            $searchArr[] = ['vpbank_transactions.'.VPBankTransaction::TN_TRANCODE, '=', trim($conditions['tn_trancode'])];
        }

        $storeCodes = [];

        $transactions = DB::table('mistaken_vpbank_transactions')
            ->select($select)
            ->leftJoin('vpbank_transactions', 'vpbank_transactions.tn_trancode', '=', 'mistaken_vpbank_transactions.tn_trancode')
            ->whereNull('vpbank_transactions.' . VPBankTransaction::DELETED_AT); // not include trashed

        if (!empty($searchArr)) {
            $transactions = $transactions->where($searchArr);
        }
        if (!empty($conditions['codeArea'])) {
            $transactions = $transactions->whereIn(TranModel::STORE_CODE_AREA, $conditions['codeArea']);
        }
        $transactions = $transactions->orderBy('vpbank_transactions.'. VPBankTransaction::TRANSACTION_DATE, 'DESC')->get();
        $result = [
            'totalAmount' => number_format($transactions->sum(VPBankTransaction::AMOUNT)),
            'totalTransaction' => number_format($transactions->count()),
            'data' => $transactions
        ];
        if(!empty($searchEmptyTrans)) {
            $emptyAutoTrans = DB::table('vpbank_transactions')
            ->select('amount', 'transactionId', 'transactionDate', DB::raw(" 'Chưa tạo phiếu thu' AS approve_note"))
            ->whereNull('vpbank_transactions.' . VPBankTransaction::DELETED_AT) // not include trashed
            ->where($searchEmptyTrans)
            ->where('vpbank_transactions.' . VPBankTransaction::VIRTUAL_ACCOUNT_NUMBER, '!=', '')
            ->whereNull(VPBankTransaction::TN_TRANCODE)
            ->orderBy('vpbank_transactions.' . VPBankTransaction::TRANSACTION_DATE, 'DESC')
            ->get();
            if ($emptyAutoTrans->count() > 0 && $transactions->count() > 0) {
                $transactions = $transactions->merge($emptyAutoTrans);
                $result = [
                    'totalAmount' => number_format($transactions->sum(VPBankTransaction::AMOUNT)),
                    'totalTransaction' => number_format($transactions->count()),
                    'data' => $transactions
                ];
            } else if ($emptyAutoTrans->count() > 0) {
                $result = [
                    'totalAmount' => number_format($emptyAutoTrans->sum(VPBankTransaction::AMOUNT)),
                    'totalTransaction' => number_format($emptyAutoTrans->count()),
                    'data' => $emptyAutoTrans
                ];
            }
        }
        return $result;
    }

    protected function queryLoaiThanhToan() {
        $select = "(CASE
                WHEN ".TranModel::TYPE_PAYMENT." = ".TranModel::TYPE_PAYMENT_TERM. "
                    AND ". TranModel::TYPE." = ".TranModel::TYPE_TAT_TOAN . "
                    THEN '".TranModel::TYPE_TAT_TOAN_TEXT."'
                WHEN ".TranModel::TYPE_PAYMENT." = ".TranModel::TYPE_PAYMENT_TERM. "
                    AND ". TranModel::TYPE." = ".TranModel::TYPE_THANH_TOAN_KY . "
                    THEN '".TranModel::TYPE_THANH_TOAN_TEXT."'
                WHEN ".TranModel::TYPE_PAYMENT." = ".TranModel::TYPE_PAYMENT_CC. "
                    THEN '".TranModel::TYPE_PAYMENT_CC_TEXT."'
                WHEN ".TranModel::TYPE_PAYMENT." = ".TranModel::TYPE_PAYMENT_GH. "
                    THEN '".TranModel::TYPE_PAYMENT_GH_TEXT."'
                ELSE '".TranModel::UNKNOW_TEXT."'
            END) AS ".TranModel::LOAI_THANH_TOAN_TEXT;
        return $select;
    }

    protected function querySelectStatus() {
        $select = "(CASE
                WHEN mistaken_vpbank_transactions.".TranModel::STATUS." = '".TranModel::STATUS_NEW. "'
                    THEN '".TranModel::STATUS_NEW_TEXT."'
                WHEN mistaken_vpbank_transactions.".TranModel::STATUS." = ".TranModel::STATUS_SUCCESS. "
                    THEN '".TranModel::STATUS_SUCCESS_TEXT."'
                WHEN mistaken_vpbank_transactions.".TranModel::STATUS." = ".TranModel::STATUS_WAIT_CONFIRM. "
                    THEN '".TranModel::STATUS_WAIT_CONFIRM_TEXT."'
                WHEN mistaken_vpbank_transactions.".TranModel::STATUS." = ".TranModel::STATUS_CANCLED. "
                    THEN '".TranModel::STATUS_CANCLED_TEXT."'
                WHEN mistaken_vpbank_transactions.".TranModel::STATUS." = ".TranModel::STATUS_HAVENT_EVIDENCE. "
                    THEN '".TranModel::STATUS_HAVENT_EVIDENCE_TEXT."'
                WHEN mistaken_vpbank_transactions.".TranModel::STATUS." = ".TranModel::STATUS_RETURNED. "
                    THEN '".TranModel::STATUS_RETURNED_TEXT."'
                ELSE '".TranModel::UNKNOW_TEXT."'
            END) AS ".TranModel::STATUS_TEXT;
        return $select;
    }

    public function searchMistakenOnDatePayAndStoreID($conditions)
    {
        $searchArr = [];
        $transactions = DB::table('mistaken_vpbank_transactions');
        if (!empty($conditions['start_date_pay'])) {
            $startDate = $conditions['start_date_pay'];
            $searchArr[] = ['mistaken_vpbank_transactions.' . $this->vpbTranModel::DATE_PAY, '>=', trim($startDate)];
        }
        if (!empty($conditions['end_date_pay'])) {
            $endDate = $conditions['end_date_pay'];
            $searchArr[] = ['mistaken_vpbank_transactions.' . $this->vpbTranModel::DATE_PAY, '<=', trim($endDate)];
        }
        $searchArr[] = ['mistaken_vpbank_transactions.' . $this->vpbTranModel::STATUS, "=", $this->vpbTranModel::STATUS_SUCCESS];
        if (!empty($searchArr)) {
            $transactions = $transactions->where($searchArr);
        }
        if (!empty($conditions['place'])) {
            $transactions = $transactions->whereIn('mistaken_vpbank_transactions.' . TranModel::STORE_ID, $conditions['place']);
        }
        $transactions = $transactions->get();
        $result = [
            'data' => $transactions
        ];
        return $result;
    }



}
