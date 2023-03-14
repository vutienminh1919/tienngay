<?php

namespace Modules\MysqlCore\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoMoApp extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'epayment_transactions';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Column name table
     */
    const REQUEST_CHECK_BILL            = 'request_check_bill';
    const REQUEST_NOTIFY_PAYMENT        = 'request_notify_payment';
    const TRANSACTIONID                 = 'transactionId';
    const CONTRACT_ID                   = 'contract_id';
    const CONTRACT_CODE                 = 'contract_code';
    const CONTRACT_CODE_DISBURSEMENT    = 'contract_code_disbursement';
    const CONTRACT_STATUS               = 'contract_status';
    const CONTRACT_STORE_ID             = 'contract_store_id';
    const CONTRACT_STORE_NAME           = 'contract_store_name';
    const CONTRACT_TRANSACTION_ID       = 'contract_transaction_id';
    const TRANSACTION_FEE               = 'transaction_fee';
    const EPAYMENT_CODE                 = 'epayment_code';
    const EPAYMENT_NAME                 = 'epayment_name';
    const PAYMENT_OPTION                = 'payment_option';
    const STATUS                        = 'status';
    const TOTAL_AMOUNT                  = 'total_amount';
    const PAID_AMOUNT                   = 'paid_amount';
    const PAID_DATE                     = 'paid_date';
    const NAME                          = 'name';
    const EMAIL                         = 'email';
    const MOBILE                        = 'mobile';
    const IDENTITY_CARD                 = 'identity_card';
    const DEBT_AMOUNT                   = 'debt_amount';
    const LATE_FEE                      = 'late_fee';
    const ACTUAL_UNPAID_FEE             = 'actual_unpaid_fee';
    const EARLY_REPAYMENT_CHARGE        = 'early_repayment_charge';
    const COST_INCURRED                 = 'cost_incurred';
    const UNPAID_MONEY                  = 'unpaid_money';
    const BALANCE_PREV_TERM             = 'balance_prev_term';
    const EXCESS_PAYMENT                = 'excess_payment';
    const NEXT_PAYMENT_AMOUNT           = 'next_payment_amount';
    const CREATED_AT                    = 'created_at';
    const UPDATED_AT                    = 'updated_at';
    const CONFIRMED                     = 'confirmed';
    const TRANSACTION_RECONCILIATION_ID = 'transaction_reconciliation_id';
    const CHECK_SUM_KEY                 = 'checkSumKey';
    const CLIENT_CODE                   = 'client_code';
    const NOTIFYURL                     = 'notifyUrl';
    const DISCOUNTED_FEE                = 'discounted_fee';

    //const value
    const EPAYMENT_CODE_VALUE = 3; // 3: momo
    const TRANSACTION_PENDING = 1; // not payment yet
    const TRANSACTION_SUCCESS = 2; // paid already
    const CONTRACT_STATUS_PENDING = 1; //waiting for progressing
    const CONTRACT_STATUS_SUCCESS = 2; //paid the debt
    const CONFIRMED_PENDING = 1; // not confirm yet
    const CONFIRMED_SUCCESS = 2; // confirmed already

    const CLIENT_CODE_MOMOAPP          = NULL; //momo app
    const CLIENT_CODE_IOS_APPKH        = 1; //ios appkh
    const CLIENT_CODE_ANDROID_APPKH    = 2; //android appkh
    const CLIENT_CODE_WEB_APPKH        = 3; //web
    const PAYMENT_OPTION_TERM          = 1; // payment term
    const PAYMENT_OPTION_FINAL         = 2; // final settlement
    const PAYMENT_OPTION_INVESTOR      = 3; // Investor transaction request

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::REQUEST_CHECK_BILL,
        self::REQUEST_NOTIFY_PAYMENT,
        self::TRANSACTIONID,
        self::CONTRACT_ID,
        self::CONTRACT_CODE,
        self::CONTRACT_CODE_DISBURSEMENT,
        self::CONTRACT_STATUS,
        self::CONTRACT_STORE_ID,
        self::CONTRACT_STORE_NAME,
        self::CONTRACT_TRANSACTION_ID,
        self::TRANSACTION_FEE,
        self::PAYMENT_OPTION,
        self::STATUS,
        self::TOTAL_AMOUNT,
        self::PAID_AMOUNT,
        self::PAID_DATE,
        self::NAME,
        self::EMAIL,
        self::MOBILE,
        self::IDENTITY_CARD,
        self::DEBT_AMOUNT,
        self::LATE_FEE,
        self::ACTUAL_UNPAID_FEE,
        self::EARLY_REPAYMENT_CHARGE,
        self::COST_INCURRED,
        self::UNPAID_MONEY,
        self::BALANCE_PREV_TERM,
        self::EXCESS_PAYMENT,
        self::NEXT_PAYMENT_AMOUNT,
        self::CHECK_SUM_KEY,
        self::CLIENT_CODE,
        self::NOTIFYURL,
        self::DISCOUNTED_FEE,
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        self::CONTRACT_STATUS => self::CONTRACT_STATUS_PENDING,
        self::EPAYMENT_CODE => self::EPAYMENT_CODE_VALUE,
        self::EPAYMENT_NAME => 'MoMo App',
    ];

    /**
     * Get table name function
     *
     * @return string
     */
    public function getTableName() {
        return $this->table;
    }

    public static function getContractStatusText($statusValue) {
        switch ($statusValue) {
            case self::CONTRACT_STATUS_PENDING:
                return 'Đang xử lý';
                break;
            case self::CONTRACT_STATUS_SUCCESS:
                return 'Đã trừ tiền kỳ';
                break;
            default:
                return 'Không xác định';
                break;
        }
    }

    public static function getStatusText($status) {
        switch ($status) {
            case self::TRANSACTION_PENDING:
                return 'Chưa thanh toán';
                break;
            case self::TRANSACTION_SUCCESS:
                return 'Đã thanh toán';
                break;
            default:
                return 'Không xác định';
                break;
        }
    }

    public static function getPaymentOptionText($paymentOption) {
        switch ($paymentOption) {
            case self::PAYMENT_OPTION_TERM:
                return 'Thanh toán kỳ';
                break;
            case self::PAYMENT_OPTION_FINAL:
                return 'Tất toán';
                break;
            case self::PAYMENT_OPTION_INVESTOR:
                return 'Nhà đầu tư';
                break;
            default:
                return 'Không xác định';
                break;
        }
    }
}
