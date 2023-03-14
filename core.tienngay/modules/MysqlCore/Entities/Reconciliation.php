<?php

namespace Modules\MysqlCore\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTime;

class Reconciliation extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaction_reconciliations';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Column name table
     */
    const CODE                          = 'code';
    const PAY_AMOUNT                    = 'pay_amount';
    const PAID_AMOUNT                   = 'paid_amount';
    const PAID_DATE                     = 'paid_date';
    const STATUS                        = 'status';
    const CREATED_BY                    = 'created_by';
    const UPDATED_BY                    = 'updated_by';
    const CREATED_AT                    = 'created_at';
    const UPDATED_AT                    = 'updated_at';
    const DELETED_AT                    = 'deleted_at';

    //const value
    const STATUS_NOTSENDEMAIL = 1; // chưa gửi email
    const STATUS_SENDEMAIL = 2; // đang gửi email
    const STATUS_PENDING = 3; //chờ thanh toán
    const STATUS_SUCCESS = 4;   // đã nhận tiền thanh toán
    const STATUS_UNDERPAYMENT = 5; // trả thiếu
    const STATUS_OVERPAYMENT = 6;   // trả thừa


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::CODE,
        self::PAY_AMOUNT,
        self::PAID_DATE,
        self::STATUS,
        self::CREATED_BY,
        self::UPDATED_BY,
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        self::STATUS => self::STATUS_NOTSENDEMAIL,
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
