<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class UserCpanel extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'user';

    public $timestamps = false;
    /**
     * initial constants
     */
    const EMAIL                 = 'email';
    const STATUS                = 'status';
    const TOKEN_WEB             = 'token_web';
    const FULL_NAME             = 'full_name';
    const PHONE_NUMBER          = 'phone_number';
    const IDENTITY_CARD         = 'identify';
    const TYPE                  = 'type';
    const AUTH                  = 'auth';       // status auth ekyc
    const FRONT_CARD            = 'front_facing_card';      // cccd/cmnd mặt trước
    const BACK_CARD             = 'card_back';              // cccd/cmnd mặt sau
    const AVATAR                = 'portrait';               // ảnh chân dung
    const ID                    = '_id';
    const ADDRESS               = 'address'; // địa chỉ
    const IS_SUPERADMIN         = 'is_superadmin';
    /**
     * end initial constants
     */

     const ACTIVE = 'active';
     const APPKH = "2";
     const NOT_VERIFY = 0; // chưa xác thực
     const VERIFIED = 1;    // đã xác thực
     const WAIT = 2;        // đang chờ xác thực
     const RE_VERIFED = 3;   // xác thực lại
}
