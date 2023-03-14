<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class AppkhEkycLog extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'log_appkh_ekyc';

    public $timestamps = false;

    protected $guarded = [];

    const RESPONSE          = 'response';// kết quả ekyc trả về
    const USER_ID           = "user_id";// id của user check
    const TYPE              = "type";    // status auth
    const IMAGE             = "image";  // image delete after auth failed
    const CREATED_AT        = "created_at";

    const SUCCESS           = 'success';// auth thành công
    const FAILED            = 'failed';// auth lại

}
