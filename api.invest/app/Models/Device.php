<?php


namespace App\Models;


class Device extends BaseModel
{
    const COLUMN_DEVICE_TOKEN = 'device_token';
    const COLUMN_STATUS = 'status';
    const COLUMN_USER_ID = 'user_id';
    const COLUMN_PLATFORM = 'platform';

    protected $table = 'device';

    //platform
    const APP = 'app';
    const WEB = 'web';

    public function user()
    {
        return $this->belongsTo(User::class, self::COLUMN_USER_ID);
    }


}
