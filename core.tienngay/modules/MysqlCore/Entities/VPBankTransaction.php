<?php

namespace Modules\MysqlCore\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VPBankTransaction extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vpbank_transactions';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    const STATUS_PENDING = 1;       // chờ gạch nợ
    const STATUS_SUCCESS = 2;       // đã gạch nợ
    const STATUS_PENDING_TEXT = 'Đang xử lý';       // chờ gạch nợ
    const STATUS_SUCCESS_TEXT = 'Đã trừ tiền kỳ';       // đã gạch nợ
    const UNKNOW_TEXT = 'Không xác định';       // đã gạch nợ

    const TRAN_STATUS_ACTIVE = 1;    // thành công
    const TRAN_STATUS_INACTIVE = 2;  // đã huỷ
    const ACTIVE_TEXT = 'Thành công';
    const INACTIVE_TEXT = 'Đã huỷ';

    const CONFIRMED_PENDING = 1;    // chờ đối soát
    const CONFIRMED_SUCCESS = 2;    // đã đối soát
    const CONFIRMED_ADDITIONAL = 3; // đối soát bổ sung

    const CONFIRMED_PENDING_TEXT = 'Chưa đối soát';
    const CONFIRMED_SUCCESS_TEXT = 'Đã đối soát';
    const CONFIRMED_ADDITIONAL_TEXT = 'Đối soát bổ sung';

    const STATUS_TEXT = 'status_text';    // đối soát ngày
    const DAILY_CONFIRMED_TEXT = 'daily_confirmed_text';    // đối soát ngày
    const MONTHLY_CONFIRMED_TEXT = 'monthly_confirmed_text';    // đối soát tháng
    const TRAN_STATUS_TEXT = 'tran_status_text';    // đối soát tháng

    const RUN_PAYMENT_PENDING = 1; // đang chờ được thanh toán
    const RUN_PAYMENT_SUCCESS = 2; // đã tạo thanh toán

    /**
     * Column name table
     */
    const ID                                = 'id';
    const MASTER_ACCOUNT_NUMBER             = 'masterAccountNumber';
    const VIRTUAL_ACCOUNT_NUMBER            = 'virtualAccountNumber';
    const VIRTUAL_NAME                      = 'virtualName';
    const AMOUNT                            = 'amount';
    const REMARK                            = 'remark';
    const TRANSACTION_ID                    = 'transactionId';
    const TRANSACTION_DATE                  = 'transactionDate';
    const BOOKING_DATE                      = 'bookingDate';
    const STATUS                            = 'status'; // trạng thái gạch nợ
    const TRAN_STATUS                       = 'tran_status'; // trạng thái giao dịch (thành công or đã huỷ)
    const CONTRACT_ID                       = 'contract_id';
    const CONTRACT_CODE                     = 'contract_code';
    const CONTRACT_CODE_DISBURSEMENT        = 'contract_code_disbursement';
    const NAME                              = 'name';
    const EMAIL                             = 'email';
    const MOBILE                            = 'mobile';
    const IDENTITY_CARD                     = 'identity_card';
    const TN_TRANSACTIONID                  = 'tn_transactionId';
    const TN_TRANCODE                       = 'tn_trancode';
    const DELETED_AT                        = 'deleted_at';
    const STORE_ID                          = 'store_id';
    const STORE_NAME                        = 'store_name';
    const STORE_ADDRESS                     = 'store_address';
    const STORE_CODE_ADDRESS                = 'store_code_address';
    const CREATED_AT                        = 'created_at';
    const UPDATED_AT                        = 'updated_at';
    const DAILY_CONFIRMED                   = 'daily_confirmed';
    const MONTHLY_CONFIRMED                 = 'monthly_confirmed';
    const VITUAL_ALTKEY_CODE                = 'vitualAltKeyCode';
    const VITUAL_ALTKEY_NAME                = 'vitualAltKeyName';
    const RUN_PAYMENT                       = 'run_payment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::MASTER_ACCOUNT_NUMBER,
        self::VIRTUAL_ACCOUNT_NUMBER,
        self::VIRTUAL_NAME,
        self::AMOUNT,
        self::REMARK,
        self::TRANSACTION_ID,
        self::TRANSACTION_DATE,
        self::BOOKING_DATE,
        self::STATUS,
        self::TRAN_STATUS,
        self::CONTRACT_ID,
        self::CONTRACT_CODE,
        self::CONTRACT_CODE_DISBURSEMENT,
        self::NAME,
        self::EMAIL,
        self::MOBILE,
        self::IDENTITY_CARD,
        self::TN_TRANSACTIONID,
        self::TN_TRANCODE,
        self::STORE_ID,
        self::STORE_NAME,
        self::STORE_ADDRESS,
        self::STORE_CODE_ADDRESS,
        self::DAILY_CONFIRMED,
        self::MONTHLY_CONFIRMED,
        self::VITUAL_ALTKEY_CODE,
        self::VITUAL_ALTKEY_NAME,
        self::RUN_PAYMENT
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        self::STATUS => self::STATUS_PENDING,
        self::TRAN_STATUS => self::TRAN_STATUS_ACTIVE,
        self::DAILY_CONFIRMED => self::CONFIRMED_PENDING,
        self::MONTHLY_CONFIRMED => self::CONFIRMED_PENDING,
        self::RUN_PAYMENT => self::RUN_PAYMENT_PENDING
    ];

    /**
     * Get table name function
     *
     * @return string
     */
    public function getTableName() {
        return $this->table;
    }


}
