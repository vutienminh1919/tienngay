<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Contract extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'contract';

    protected $primaryKey = '_id';

    public $timestamps = false;

    /**
     * initial constants
     */
    const CODE_CONTRACT                 = 'code_contract';
    const CUSTOMER_IDENTITY_CARD        = 'customer_infor.customer_identify';
    const CUSTOMER_IDENTITY_CARD_OLD    = 'customer_infor.customer_identify_old';
    const CUSTOMER_PHONE_NUMBER         = 'customer_infor.customer_phone_number';
    const STATUS                        = 'status';
    const CODE_CONTRACT_PARENT_GH       = 'code_contract_parent_gh';
    const CODE_CONTRACT_PARENT_CC       = 'code_contract_parent_cc';
    const CUSTOMER_NAME                 = 'customer_infor.customer_name';
    const CODE_CONTRACT_DISBURSEMENT    = 'code_contract_disbursement';
    /**
     * end initial constants
     */

    public static function list_array_trang_thai_dang_vay()
    {
        return [
            11, 12, 13, 14, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 37, 38, 39, 41, 42
        ];
    }

    const DA_HUY            = 3;
    const TAT_TOAN          = 19;
    const DA_THANH_LY       = 40;
}
