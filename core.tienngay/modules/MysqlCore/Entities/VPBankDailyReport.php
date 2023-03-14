<?php

namespace Modules\MysqlCore\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VPBankDailyReport extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vpbank_daily_report_transactions';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    const STATUS_PENDING = 1;
    const STATUS_SUCCESS = 2;

    /**
     * Column name table
     */
    const ID                                = 'id';
    const FILE_NAME                         = 'filename';
    const VIRTUAL_ACCOUNT_NUMBER            = 'virtualAccountNumber';
    const AMOUNT                            = 'amount';
    const REMARK                            = 'remark';
    const TRANSACTION_ID                    = 'transactionId';
    const TRANSACTION_DATE                  = 'transactionDate';
    const BOOKING_DATE                      = 'bookingDate';
    const STATUS                            = 'status';
    const NOTIFICATION                      = 'notification';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::VIRTUAL_ACCOUNT_NUMBER,
        self::AMOUNT,
        self::REMARK,
        self::TRANSACTION_ID,
        self::TRANSACTION_DATE,
        self::BOOKING_DATE,
        self::STATUS,
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        self::STATUS => self::STATUS_PENDING,
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
