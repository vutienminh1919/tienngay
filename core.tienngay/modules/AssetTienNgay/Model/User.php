<?php

namespace Modules\AssetTienNgay\Model;

class User extends BaseModel
{
    protected $connection = 'mongodb-asset';
    public $timestamps = FALSE;

    const ID = '_id';
    const EMAIL = 'email';
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const PHONE_NUMBER = 'phone_number';
    const FULL_NAME = 'full_name';
    const IDENTIFY = 'identify';
    const STATUS = 'status';
    const TYPE = 'type';
    const TOKEN_WEB = 'token_web';
    const TOKEN_APP = 'token_app';

    //status
    const NEW = 'new';
    const ACTIVE = 'active';
    const DEACTIVE = 'deactive';

    //type
    const NHAN_VIEN = '1';
    const KHACH_HANG = '2';

    protected $collection = 'user';
}
