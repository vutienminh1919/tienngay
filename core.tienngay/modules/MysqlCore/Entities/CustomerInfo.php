<?php

namespace Modules\MysqlCore\Entities;

use Illuminate\Database\Eloquent\Model;
use Log;

class CustomerInfo extends Model
{
    protected $connection = 'mysql';

    protected $table = 'customer_info';

    protected $fillable = ['customer_status', 'customer_name', 'customer_email', 'customer_phone_number', 'customer_identify',
        'customer_identify_front_side', 'customer_identify_back_side', 'customer_identify_avatar_image', 'customer_identify_date',
        'customer_identify_address', 'old_customer_identify', 'passport_number', 'passport_address', 'passport_date',
        'customer_resources', 'customer_gender', 'customer_BOD', 'marriage', 'current_province', 'current_province_name',
        'current_district', 'current_district_name', 'current_ward', 'current_ward_name', 'current_stay', 'current_form_residence',
        'current_time_life', 'house_hold_province', 'house_hold_province_name', 'house_hold_district', 'house_hold_district_name',
        'house_hold_ward', 'house_hold_ward_name', 'house_hold_address', 'customer_relationships', 'created_at', 'updated_at',
    ];

    /**
     * initial constants
     */
    // customer status
    const NEW_CUSTOMER = 1;
    const OLD_CUSTOMER = 2;
    // marriage
    const MARRIED = 1;
    const NOT_MARRY = 2;
    const DIVORCE  = 3; // ly hon

    /**
     * end initial constants
     */

    /**
     * columns constants
    */
    const COLUMN_ID = "id";
    const COLUMN_CUSTOMER_STATUS = "customer_status";
    const COLUMN_CUSTOMER_NAME = "customer_name";
    const COLUMN_CUSTOMER_EMAIL = "customer_email";
    const COLUMN_CUSTOMER_PHONE_NUMBER = "customer_phone_number";
    const COLUMN_CUSTOMER_IDENTIFY = "customer_identify";
    const COLUMN_CUSTOMER_IDENTIFY_FRONT_SIDE = "customer_identify_front_side";
    const COLUMN_CUSTOMER_IDENTIFY_BACK_SIDE = "customer_identify_back_side";
    const COLUMN_CUSTOMER_IDENTIFY_AVATAR_IMAGE = "customer_identify_avatar_image";
    const COLUMN_CUSTOMER_IDENTIFY_DATE = "customer_identify_date";
    const COLUMN_CUSTOMER_IDENTIFY_ADDRESS = "customer_identify_address";
    const COLUMN_OLD_CUSTOMER_IDENTIFY = "old_customer_identify";
    const COLUMN_PASSPORT_NUMBER = "passport_number";
    const COLUMN_PASSPORT_ADDRESS = "passport_address";
    const COLUMN_PASSPORT_DATE = "passport_date";
    const COLUMN_CUSTOMER_RESOURCES = "customer_resources";
    const COLUMN_CUSTOMER_GENDER = "customer_gender";
    const COLUMN_CUSTOMER_BOD = "customer_BOD";
    const COLUMN_MARRIAGE = "marriage";
    const COLUMN_CURRENT_PROVINCE = "current_province";
    const COLUMN_CURRENT_PROVINCE_NAME = "current_province_name";
    const COLUMN_CURRENT_DISTRICT = "current_district";
    const COLUMN_CURRENT_DISTRICT_NAME = "current_district_name";
    const COLUMN_CURRENT_WARD = "current_ward";
    const COLUMN_CURRENT_WARD_NAME = "current_ward_name";
    const COLUMN_CURRENT_STAY = "current_stay";
    const COLUMN_CURRENT_FORM_RESIDENCE = "current_form_residence";
    const COLUMN_CURRENT_TIME_LIFE = "current_time_life";
    const COLUMN_HOUSE_HOLD_PROVINCE = "house_hold_province";
    const COLUMN_HOUSE_HOLD_PROVINCE_NAME = "house_hold_province_name";
    const COLUMN_HOUSE_HOLD_DISTRICT = "house_hold_district";
    const COLUMN_HOUSE_HOLD_DISTRICT_NAME = "house_hold_district_name";
    const COLUMN_HOUSE_HOLD_WARD = "house_hold_ward";
    const COLUMN_HOUSE_HOLD_WARD_NAME = "house_hold_ward_name";
    const COLUMN_HOUSE_HOLD_ADDRESS = "house_hold_address";
    const COLUMN_CUSTOMER_RELATIONSHIPS = "customer_relationships";
    const COLUMN_CREATED_AT = "created_at";
    const COLUMN_UPDATED_AT = "updated_at";

    /**
     * end of columns constants
    */
}
