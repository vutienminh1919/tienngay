<?php

namespace Modules\MongodbCore\Repositories;


use Illuminate\Database\Eloquent\Model;
use Modules\MongodbCore\Entities\Transaction;
use Modules\MongodbCore\Entities\Store;
use Modules\MongodbCore\Entities\LogTran;
use Modules\MongodbCore\Repositories\Interfaces\TransactionRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;

class TransactionRepository implements TransactionRepositoryInterface
{

    /**      
     * @var Model      
     */     
     protected $tranModel;

    /**
     * TransactionRepository constructor.
     *
     * @param Transaction $store
     */
    public function __construct(Transaction $transaction) {
        $this->tranModel = $transaction;
    }

    /**
     * Get transaction which has paid by cash is exist and not confirmed yet
     *
     * @param array $contractCodes
     * @return collection
     */
    public function getCashTran($contractCodes) {
        $result = $this->tranModel::whereIn($this->tranModel::CODE_CONTRACT, $contractCodes)
            ->whereIn($this->tranModel::PAYMENT_METHOD, array($this->tranModel::PAYMENT_METHOD_CASH, (int)$this->tranModel::PAYMENT_METHOD_CASH))
            ->where($this->tranModel::STATUS, $this->tranModel::STATUS_WAIT_CONFIRM)
            ->get();
        return $result;
    }

    /**
     * update transaction which has paid by cash
     *
     * @param string $id
     * @param array $data
     * @return collection
     */
    public function updateCashTran($id, $data) {
        $update = [];
        if (isset($data['note'])) {
            $update[$this->tranModel::NOTE] = $data['note'];
        }
        if (isset($data['paid_date'])) {
            $update[$this->tranModel::DATE_PAY] = $data['paid_date'];
        }
        if (isset($data['code_transaction_bank'])) {
            $update[$this->tranModel::CODE_TRANSACTION_BANK] = $data['code_transaction_bank'];
        }
        if (isset($data['status'])) {
            $update[$this->tranModel::STATUS] = $data['status'];
        }
        if (isset($data['bank'])) {
            $update[$this->tranModel::BANK] = $data['bank'];
        }
        if (empty($update)) {
            return false;
        }
        $transaction = $this->tranModel::where($this->tranModel::ID, $id)
            ->first();
        if (empty($transaction)) {
            return false;
        }
        $update[$this->tranModel::BANK_APPROVE_TIME] = time();
        $logTrans = [
            LogTran::TRAN_ID    => (string)$id,
            LogTran::ACTION     => LogTran::KT_DUYET,
            LogTran::OLD_LOG    => $transaction->toArray(),
            LogTran::NEW_LOG    => $update,
            LogTran::CREATED_AT => time(),
            LogTran::CREATED_BY => "System"
        ];
        LogTran::insert($logTrans);
        $result = $this->tranModel::where($this->tranModel::ID, $id)
            ->update($update);
        return $result;
    }

    /**
     * create PTI BHTN transaction
     *
     * @param array $data
     * @return collection
     */
    public function createBHTNTrans($data) {
        $dataCreate = [];
        if (isset($data['total'])) {
            $dataCreate[$this->tranModel::TOTAL] = $data['total'];
        }
        if (isset($data['payment_method'])) {
            $dataCreate[$this->tranModel::PAYMENT_METHOD] = $data['payment_method'];
        }
        if (isset($data['customer_bill_name'])) {
            $dataCreate[$this->tranModel::CUSTOMER_BILL_NAME] = $data['customer_bill_name'];
        }
        if (isset($data['customer_bill_phone'])) {
            $dataCreate[$this->tranModel::CUSTOMER_BILL_PHONE] = $data['customer_bill_phone'];
        }
        if (isset($data['approve_note'])) {
            $dataCreate[$this->tranModel::APPROVE_NOTE] = $data['approve_note'];
        }
        if (isset($data['bank'])) {
            $dataCreate[$this->tranModel::BANK] = $data['bank'];
        }
        if (isset($data['code_transaction_bank'])) {
            $dataCreate[$this->tranModel::CODE_TRANSACTION_BANK] = $data['code_transaction_bank'];
        }
        if (isset($data['store'])) {
            $dataCreate[$this->tranModel::STORE] = $data['store'];
        }
        if (empty($dataCreate)) {
            return false;
        }
        $currentTime = new DateTime("NOW");
        $dataCreate[$this->tranModel::GOI] = $data['goi'];
        $dataCreate[$this->tranModel::CODE] = 'PT' . $currentTime->format('ymd') . '_BHTN'.$data['goi'].'_' . $currentTime->format('His');
        $dataCreate[$this->tranModel::TYPE] = $this->tranModel::TYPE_PAYMENT_BHTN;
        $dataCreate[$this->tranModel::STATUS] = $this->tranModel::STATUS_SUCCESS;
        $dataCreate[$this->tranModel::LOAI_KHACH] = $this->tranModel::LOAI_KHACH_BN;
        $dataCreate[$this->tranModel::APPROVE_AT] = time();
        $dataCreate[$this->tranModel::CREATED_AT] = time();
        $dataCreate[$this->tranModel::UPDATED_AT] = time();
        if (isset($data['approve_by'])) {
            $dataCreate[$this->tranModel::APPROVE_BY] = $data['approve_by'];
        } else {
            $dataCreate[$this->tranModel::APPROVE_BY] = "System";
        }
        if (isset($data['created_by'])) {
            $dataCreate[$this->tranModel::CREATED_BY] = $data['created_by'];
            $dataCreate[$this->tranModel::UPDATED_BY] = $data['updated_by'];
        } else {
            $dataCreate[$this->tranModel::CREATED_BY] = "System";
            $dataCreate[$this->tranModel::UPDATED_BY] = "System";
        }
        $result = $this->tranModel::create($dataCreate);
        return $result;
    }

    /**
     * get transaction by bank code
     *
     * @param string $bankCode
     * @return collection
     */
    public function getTransByBankCode($bankCode) {
        $transactions = $this->tranModel::where($this->tranModel::CODE_TRANSACTION_BANK, $bankCode)
            ->whereIn($this->tranModel::STATUS, [$this->tranModel::STATUS_WAIT_CONFIRM, $this->tranModel::STATUS_SUCCESS])
            ->get();
        return $transactions;
    }


}
