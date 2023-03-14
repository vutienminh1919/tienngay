<?php

namespace Modules\MysqlCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MysqlCore\Entities\VPBankTransaction as TranModel;
use Modules\MongodbCore\Entities\Store as StoreModel;
use Modules\MysqlCore\Repositories\Interfaces\VPBankTransactionRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Str;

class VPBankTransactionRepository implements VPBankTransactionRepositoryInterface
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
            "vpbank_transactions.*, vpbank_vans.virtualAccName as van_name, " 
            . $this->querySelectStatus() . ", " 
            . $this->querySelectDailyConfirmed() . ", " 
            . $this->querySelectMonthlyConfirmed() . ", " 
            . $this->querySelectTranStatus()
        );
        $transaction = $this->vpbTranModel->select($select)
        ->leftJoin('vpbank_vans', 'vpbank_vans.virtualAccNo', '=', 'vpbank_transactions.virtualAccountNumber')
        ->whereNull('vpbank_transactions.' . $this->vpbTranModel::DELETED_AT) // not include trashed
        ->find($id);
        return $transaction;
    }

    /**
     * update transaction.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function update($id, $attributes) {
        $transaction = $this->vpbTranModel::find($id)->update($attributes);
        return $transaction;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $attributes
     * @return boolean
     */
    public function findByTranctionId($transactionId) {
        $transaction = $this->vpbTranModel::where($this->vpbTranModel::TRANSACTION_ID, $transactionId)->first();
        return $transaction;
    }

    /**
     * @param $time fomat yyyy-mm-dd
     * get transaction by month
     * @return collection
     */
    public function getListByMonth($time) {
        $select = DB::raw(
            "vpbank_transactions.*, vpbank_vans.virtualAccName as van_name, " 
            . $this->querySelectStatus() . ", " 
            . $this->querySelectDailyConfirmed() . ", " 
            . $this->querySelectMonthlyConfirmed() . ", " 
            . $this->querySelectTranStatus()
        );
        // First day of the month.
        $startDate =  date('Y-m-01 00:00:00', strtotime($time));
        // Last day of the month.
        $endDate = date('Y-m-t 23:59:59', strtotime($time));
        $transactions = DB::table('vpbank_transactions')
            ->select($select)
            ->leftJoin('vpbank_vans', 'vpbank_vans.virtualAccNo', '=', 'vpbank_transactions.virtualAccountNumber')
            ->whereBetween(
                'vpbank_transactions.'.$this->vpbTranModel::TRANSACTION_DATE, [$startDate, $endDate]
            )
            ->whereNull('vpbank_transactions.' . $this->vpbTranModel::DELETED_AT) // not include trashed
            ->get();
        $result = [
            'totalAmount' => number_format($transactions->sum($this->vpbTranModel::AMOUNT)),
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
        $searchArr = [];
        if(!empty($conditions['masterAccountNumber'])) {
            $searchArr[] = [TranModel::MASTER_ACCOUNT_NUMBER, '=', trim($conditions['masterAccountNumber'])];
        }
        if(!empty($conditions['transactionId'])) {
            $searchArr[] = [TranModel::TRANSACTION_ID, '=', trim($conditions['transactionId'])];
        }

        if(!empty($conditions['start_date'])) {
            $startDate =  date('Y-m-d 00:00:00', strtotime($conditions['start_date']));
            $searchArr[] = [TranModel::TRANSACTION_DATE, '>=', trim($startDate)];
        }
        if(!empty($conditions['end_date'])) {
            $endDate =  date('Y-m-d 23:59:59', strtotime($conditions['end_date']));
            $searchArr[] = [TranModel::TRANSACTION_DATE, '<=', trim($endDate)];
        }
        if(!empty($conditions['virtualAccountNumber'])) {
            $searchArr[] = [TranModel::VIRTUAL_ACCOUNT_NUMBER, '=', trim($conditions['virtualAccountNumber'])];
        }
        if(!empty($conditions['virtualName'])) {
            $searchArr[] = ['vpbank_vans.virtualAccName', '=', trim($conditions['virtualName'])];
        }
        if(!empty($conditions['contract_code'])) {
            $searchArr[] = [TranModel::CONTRACT_CODE, '=', trim($conditions['contract_code'])];
        }
        if(!empty($conditions['status'])) {
            $searchArr[] = ['vpbank_transactions.'.TranModel::STATUS, '=', trim($conditions['status'])];
        }
        if(!empty($conditions['daily_confirmed'])) {
            $searchArr[] = [TranModel::DAILY_CONFIRMED, '=', trim($conditions['daily_confirmed'])];
        }
        $storeCodes = [];
        if (!empty($conditions['storeValue'])) {
            $conditions['storeValue'] = trim($conditions['storeValue']);
            $store = $this->storeModel::select(
                $this->storeModel::NAME, 
                $this->storeModel::ADDRESS, 
                $this->storeModel::VPB_STORE_CODE
            )->get();
            $result = [];
            $pattern = '/' . Str::slug($conditions['storeValue'], ' ') . '/i';
            foreach ($store->toArray() as $key => $value) {
                if(
                    preg_match($pattern, Str::slug($value[$this->storeModel::NAME] , ' ')) ||
                    preg_match($pattern, Str::slug($value[$this->storeModel::ADDRESS] , ' ')) ||
                    (isset($value[$this->storeModel::VPB_STORE_CODE]) && $value[$this->storeModel::VPB_STORE_CODE] == $conditions['storeValue'])
                ) {
                    if (isset($value[$this->storeModel::VPB_STORE_CODE])) {
                        $storeCodes[] = $value[$this->storeModel::VPB_STORE_CODE];
                    }
                }
            }
        }
        DB::enableQueryLog();
        $select = DB::raw(
            "vpbank_transactions.*, vpbank_vans.virtualAccName as van_name, " 
            . $this->querySelectStatus() . ", " 
            . $this->querySelectDailyConfirmed() . ", " 
            . $this->querySelectMonthlyConfirmed() . ", " 
            . $this->querySelectTranStatus()
        );
        if (empty($searchArr) && empty($storeCodes)) {
            $transactions = DB::table('vpbank_transactions')
            ->select($select)
            ->leftJoin('vpbank_vans', 'vpbank_vans.virtualAccNo', '=', 'vpbank_transactions.virtualAccountNumber')
            ->whereNull('vpbank_transactions.' . $this->vpbTranModel::DELETED_AT) // not include trashed
            ->get();
        } else if (!empty($searchArr) && !empty($storeCodes)) {
            $transactions = $this->vpbTranModel::select($select)
            ->leftJoin('vpbank_vans', 'vpbank_vans.virtualAccNo', '=', 'vpbank_transactions.virtualAccountNumber')
            ->where(function ($query) use ($searchArr) {
                $query->where($searchArr);
            })
            ->where(function ($query) use ($storeCodes) {
                foreach ($storeCodes as $key => $value) {
                    $query->orWhere(TranModel::VIRTUAL_ACCOUNT_NUMBER, 'LIKE', $value.'%');
                }
            })
            ->whereNull('vpbank_transactions.' . $this->vpbTranModel::DELETED_AT) // not include trashed
            ->get();
        } else {
            $transactions = $this->vpbTranModel::select($select)
            ->leftJoin('vpbank_vans', 'vpbank_vans.virtualAccNo', '=', 'vpbank_transactions.virtualAccountNumber')
            ->where(function ($query) use ($searchArr, $storeCodes) {
                if (!empty($searchArr)) {
                    $query->where($searchArr);
                }
                if (!empty($storeCodes)) {
                    foreach ($storeCodes as $key => $value) {
                        $query->orWhere(TranModel::VIRTUAL_ACCOUNT_NUMBER, 'LIKE', $value.'%');
                    }
                }
            })
            ->whereNull('vpbank_transactions.' . $this->vpbTranModel::DELETED_AT) // not include trashed
            ->get();
        }
        $result = [
            'totalAmount' => number_format($transactions->sum($this->vpbTranModel::AMOUNT)),
            'totalTransaction' => number_format($transactions->count()),
            'data' => $transactions
        ];
        return $result;
    }

    protected function querySelectStatus() {
        $select = "(CASE 
                WHEN ".'vpbank_transactions.'.TranModel::STATUS." = '".TranModel::STATUS_PENDING."' THEN '".TranModel::STATUS_PENDING_TEXT."'
                WHEN ".'vpbank_transactions.'.TranModel::STATUS." = '".TranModel::STATUS_SUCCESS."' THEN '".TranModel::STATUS_SUCCESS_TEXT."'
                ELSE '".TranModel::UNKNOW_TEXT."'
            END) AS ".TranModel::STATUS_TEXT;
        return $select;
    }

    protected function querySelectDailyConfirmed() {
        $select = "(CASE 
                WHEN ".TranModel::DAILY_CONFIRMED." = '".TranModel::CONFIRMED_PENDING."' THEN '".TranModel::CONFIRMED_PENDING_TEXT."' 
                WHEN ".TranModel::DAILY_CONFIRMED." = '".TranModel::CONFIRMED_SUCCESS."' THEN '".TranModel::CONFIRMED_SUCCESS_TEXT."' 
                WHEN ".TranModel::DAILY_CONFIRMED." = '".TranModel::CONFIRMED_ADDITIONAL."' THEN '".TranModel::CONFIRMED_ADDITIONAL_TEXT."' 
                ELSE '".TranModel::UNKNOW_TEXT."'
            END) AS ".TranModel::DAILY_CONFIRMED_TEXT;
        return $select;
    }

    protected function querySelectMonthlyConfirmed() {
        $select = "(CASE 
                WHEN ".TranModel::MONTHLY_CONFIRMED." = '".TranModel::CONFIRMED_PENDING."' THEN '".TranModel::CONFIRMED_PENDING_TEXT."' 
                WHEN ".TranModel::MONTHLY_CONFIRMED." = '".TranModel::CONFIRMED_SUCCESS."' THEN '".TranModel::CONFIRMED_SUCCESS_TEXT."' 
                WHEN ".TranModel::MONTHLY_CONFIRMED." = '".TranModel::CONFIRMED_ADDITIONAL."' THEN '".TranModel::CONFIRMED_ADDITIONAL_TEXT."' 
                ELSE '".TranModel::UNKNOW_TEXT."'
            END) AS ".TranModel::MONTHLY_CONFIRMED_TEXT;
        return $select;
    }

    protected function querySelectTranStatus() {
        $select = "(CASE 
                WHEN ".TranModel::TRAN_STATUS." = '".TranModel::TRAN_STATUS_ACTIVE."' THEN '".TranModel::ACTIVE_TEXT."' 
                WHEN ".TranModel::TRAN_STATUS." = '".TranModel::TRAN_STATUS_INACTIVE."' THEN '".TranModel::INACTIVE_TEXT."' 
                ELSE '".TranModel::UNKNOW_TEXT."'
            END) AS ".TranModel::TRAN_STATUS_TEXT;
        return $select;
    }
}
