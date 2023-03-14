<?php
namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Hcns extends Model
{
    protected $connection = "mongodb";

    protected $collection = "blacklist_hcns";

    protected $primarykey = "_id";

    public $timestamps = false;

    const ID = "_id";
    const USER_NAME = "user_name";//tên ứng viên
    const USER_IDENTIFY = "user_identify";// số cmnd/cccd
    const USER_ADDRESS = "user_address";// địa chỉ, nơi ở
    const USER_EMAIL = "user_email";// email cá nhân 
    const USER_PHONE = "user_phone";// sđt cá nhân 
    const REASON_FOR_LEAVE = "reason_for_leave";// lý do nghỉ việc 
    const DAY_OFF = "day_off";// ngày nghỉ việc
    const DAY_ON = "day_on";// ngày bắt đầu làm việc
    const PATH = "path";// url ảnh xác thực
    const CREATED_BY = "created_by";
    const UPDATED_BY = "updated_by";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";
    const DELETED_AT = "deleted_at";
    const ROOM = 'room';//phòng ban
    const POSITION = 'position';//chức vụ
    const WORK_PLACE = 'work_place';//địa điểm làm việc
    const DATE_RANGE = 'date_range';// ngày cấp cmnd/cccd
    const ISSUED_BY = 'issued_by';// nơi cấp cmnd/cccd
    const TEMPORARY_ADDRESS = 'temporary_address';// địa chỉ tạm trú
    const PERMANENT_ADDRESS = 'permanent_address';// địa chỉ thường trú
    const USER_PASSPORT = 'user_passport';// số hộ chiếu
    const SCAN = 'scan';

    protected $guarded = [];

    const YET_SCAN = 1;
    const SCANNED = 2;
}