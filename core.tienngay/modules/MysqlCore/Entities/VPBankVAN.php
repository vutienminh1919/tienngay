<?php

namespace Modules\MysqlCore\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VPBankVAN extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     * Assign vitual account number for contract
     *
     * @var string
     */
    protected $table = 'vpbank_vans';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Column name table
     */
    const ID                        = 'id';
    const VIRTUAL_ACC_NO            = 'virtualAccNo';
    const VIRTUAL_ACC_NAME          = 'virtualAccName';
    const VIRTUAL_MOBILE            = 'virtualMobile';
    const VIRTUAL_GROUP             = 'virtualGroup';
    const VIRTUAL_ALT_KEY           = 'virtualAltKey';
    const OPEN_DATE                 = 'openDate';
    const VALUE_DATE                = 'valueDate';
    const EXPIRY_DATE               = 'expiryDate';
    const MAIN_CUSTOMER_NO          = 'mainCustomerNo';
    const MAIN_ACCT_NO              = 'mainAcctNo';
    const COMPANY_NAME              = 'company_name';
    const CUSTOMER_ID               = 'customer_id';
    const STORE_CODE                = 'storeCode';
    const STATUS                    = 'status';

    const TCV                       = 'VANTCV';
    const TCVDB                     = 'VANTCVDB';
    const STATUS_ACTIVE             = 'ACTIVE';
    const STATUS_INACTIVE           = 'INACTIVE';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::VIRTUAL_ACC_NO,
        self::VIRTUAL_ACC_NAME,
        self::VIRTUAL_MOBILE,
        self::VIRTUAL_GROUP,
        self::VIRTUAL_ALT_KEY,
        self::OPEN_DATE,
        self::VALUE_DATE,
        self::EXPIRY_DATE,
        self::MAIN_CUSTOMER_NO,
        self::MAIN_ACCT_NO,
        self::COMPANY_NAME,
        self::CUSTOMER_ID,
        self::STORE_CODE,
        self::STATUS,
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
