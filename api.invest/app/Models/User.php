<?php

namespace App\Models;

class User extends BaseModel
{
    //column
    const PASSWORD = 'password';
    const FULL_NAME = 'full_name';
    const EMAIL = 'email';
    const STATUS = 'status';
    const TYPE = 'type';
    const TIME_EXPRIED_ACTIVE = "timeExpried_active";
    const TOKEN_ACTIVE = 'token_active';
    const PHONE = 'phone';
    const LAST_LOGIN = 'last_login';
    const TOKEN_APP = 'token_app';
    const ID_FACEBOOK = 'id_facebook';
    const ID_GOOGLE = 'id_google';
    const ID_APPLE = 'id_apple';
    const CHANNELS = 'channels';
    const SOURCE = 'source';
    const DATA_SOURCE = 'data_source';
    const REFERRAL_CODE = 'referral_code';
    const BLOCK_OTP = 'block_otp';
    const TIME_BLOCK_OTP = 'time_block_otp';
    const BLOCK_AT = 'block_at';
    const REFERRAL_ID = 'referral_id';
    const REFERRAL_DATE = 'referral_date';
    const TYPE_REFERRAL = 'type_referral';
    const IS_NEXTTECH = 'is_nexttech';


    // Type
    const TYPE_NHAN_VIEN = 1;
    const TYPE_NHA_DAU_TU_APP = 2;
    const TYPE_NHA_DAU_TU_UY_QUYEN = 3;

    const STATUS_ACTIVE = 'active';
    const STATUS_DEACTIVE = 'deactive';
    const STATUS_NEW = 'new';
    const STATUS_BLOCK = 'block';

    const COLUMN_MENU_ACTION = 'action';
    const COLUMN_ID = 'id';

    const CAN_DO = 1;
    const CANNOT_DO = 0;

    //type login social
    const APPLE = 'apple';
    const FACEBOOK = 'facebook';
    const GOOGLE = 'google';

    //type
    const APP = 'app';
    const CVKD = 'cvkd';

    //is_nexttect
    const NEXTER = 1;

    protected $table = 'user';

//    protected $hidden = [
//        User::PASSWORD
//    ];

    public function role()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id')
            ->withPivot('position');
    }

    public function investor()
    {
        return $this->hasOne(Investor::class, Investor::COLUMN_USER_ID);
    }

    public function menu()
    {
        return $this->belongsToMany(Menu::class, 'user_menu')
            ->withPivot(self::COLUMN_MENU_ACTION);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, Notification::COLUMN_USER_ID);
    }

    public function device()
    {
        return $this->hasOne(Device::class, Device::COLUMN_USER_ID);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class, Rate::USER_ID);
    }

}
