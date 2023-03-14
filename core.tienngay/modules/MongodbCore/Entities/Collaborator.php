<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Collaborator extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'collaborator';

    protected $guarded = [];

    public $timestamps = FALSE;

    /**
     * initial constants
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCK = 'block';

    const COLUMN_ID = "_id";
    const COLUMN_INTRODUCER_ID = "introducer_id";
    const COLUMN_PHONE_INTRODUCE = "phone_introduce";
    const COLUMN_CTV_NAME = "ctv_name";
    const COLUMN_CTV_PHONE = "ctv_phone";
    const COLUMN_CTV_PASSWORD = "password";
    const COLUMN_USER_TYPE = "user_type";
    const COLUMN_CTV_CODE = "ctv_code";
    const COLUMN_STATUS = "status";
    const COLUMN_FORM = "form";
    const COLUMN_ACCOUNT_TYPE = "account_type";
    const COLUMN_TYPE = "type";
    const COLUMN_MANAGER_ID = "manager_id";
    const COLUMN_USER_ROLE = "user_role";
    const COLUMN_STATUS_VERIFIED = 'status_verified';
    const COLUMN_CREATED_AT = "created_at";
    const COLUMN_CREATED_BY = "created_by";
    const COLUMN_UPDATED_AT = "updated_at";
    const COLUMN_UPDATED_BY = "updated_by";
    const COLUMN_CTV_DOB = "ctv_DOB";
    const COLUMN_CTV_DATE_RANGE = "ctv_ngaycap";
    const COLUMN_CTV_ISSUED_BY = "ctv_noicap";
    const COLUMN_CTV_ADDRESS = "ctv_address";
    const COLUMN_CTV_CMT = "ctv_cmt";
    const COLUMN_FRONT_CARD = "image_cmt_mattruoc";
    const COLUMN_BACK_CARD = "image_cmt_matsau";
    const COLUMN_TOKEN_APP = "token_app";

    // Tai khoan form = 1 => tai khoan CTV Ca nhan; form = 2 => tai khoan CTV Cty, Doi nhom
    const FORM_USER_INDIVIDUAL = '1';
    const FORM_USER_GROUP= '2';

    // type = 1 => CTV duoc gioi thieu; type = 2 => CTV duoc tao boi Doi nhom
    const TYPE_COLLABORATOR_INTRODUCE = '1';
    const TYPE_COLLABORATOR_GROUP = '2';
    const TYPE_ACCOUNT_PARENT = '1';
    const TYPE_ACCOUNT_CHILD = '2';

    // status_verify of user
    const NOT_VERIFY = "1";        //chưa xác thực
    const PENDING_VERIFY = "2";    // đang chờ xác thực
    const VERIFIED = "3";        // đã xác thực
    const RE_VERIFY = "4";     // xác thực lại




    /**
     * end initial constants
     */
}
