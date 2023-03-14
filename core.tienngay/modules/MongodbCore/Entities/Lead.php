<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Lead extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'lead';

    protected $guarded = [];

    public $timestamps = FALSE;

    public $casts = [
        'price' => 'integer',
    ];

    /**
     * Column name table
     */
    const COLUMN_ID = "_id";
    const COLUMN_CTV_CODE = "ctv_code";
    const COLUMN_FULL_NAME = "fullname";
    const COLUMN_PHONE_NUMBER = "phone_number";
    const COLUMN_GROUP_CTV_PHONE = "group_ctv_phone";
    const COLUMN_ACCOUNT_TYPE = "account_type";
    const COLUMN_TYPE_FINANCE = "type_finance";
    const COLUMN_STATUS_WEB = "status_web";
    const COLUMN_ORDER_TYPE = "order_type";
    const COLUMN_CREATED_AT = "created_at";
    const COLUMN_CREATED_BY = "created_by";
    const COLUMN_HK_PROVINCE = "hk_province";
    const COLUMN_HK_DISTRICT = "hk_district";
    const COLUMN_NS_PROVINCE = "ns_province";
    const COLUMN_NS_DISTRICT = "ns_district";
    const COLUMN_LOAN_AMOUNT = "loan_amount";
    const COLUMN_LOAN_TIME = "loan_time";
    const COLUMN_SOURCE = "source";
    const COLUMN_STATUS = "status";
    const COLUMN_STATUS_SALE = "status_sale";
    const COLUMN_UTM_SOURCE = "utm_source";
    const COLUMN_UTM_CAMPAIGN = "utm_campaign";
    const COLUMN_HOMEDY_STATUS = "homedy_status";
    const COLUMN_HOMEDY_ID = "homedy_id";
    const COLUMN_HOMEDY_AMOUNT = "homedy_amount";
    const COLUMN_HOMEDY_MONEY = "homedy_money";
    const COLUMN_HOMEDY_LOG = "homedy_log";
    const COLUMN_HOMEDY_SUCCESS_TIME = "homedy_success_time";
    const COLUMN_HOMEDY_DISABLE = "homedy_disable";
    const COLUMN_CSKH = "cskh";

    const ORDER_LOAN = "1"; // Sp là khoản vay
    const ORDER_INSURANCE = "2"; // Sp là bảo hiểm

    const ACCOUNT_ROOT = "1"; // Tài khoản Công ty
    const ACCOUNT_MEMBER = "2"; // Tai khoản thành viên

    const STATUS_NEW = "1";
    const STATUS_SALE_NEW = "1";
    const TYPE_FINANCE_APPLY_COMMISSION_ARRAY = [1,2,3,4,5,6,7,8,9,16]; //Các sp vay theo ô tô, xe máy

}
