<?php


namespace Modules\MongodbCore\Entities;


use Jenssegers\Mongodb\Eloquent\Model;

class NotificationPayment extends Model
{
    protected $connection = "mongodb";
    protected $collection = 'notificationPayment';

    protected $primarykey = "_id";
    public $timestamps = false;

    const COLUMN_ID = "_id";
    const COLUMN_CODE_CONTRACT = 'code_contract';//mã hợp đồng
    const COLUMN_HOP_DONG_SO = 'hop_dong_so';//hợp đồng số (phụ lục hợp đồng và hợp đồng gốc)
    const COLUMN_CREATED_BY = "created_by";
    const COLUMN_UPDATED_BY = "updated_by";
    const COLUMN_CREATED_AT = "created_at";
    const COLUMN_UPDATED_AT = "updated_at";
    const COLUMN_ONE_MONTH_RENT = "one_month_rent";//giá thuê/tháng(giá thuê đang áp dụng)
    const COLUMN_NGAY_THANH_TOAN = "ngay_thanh_toan";//ngày thanh toán gốc
    const COLUMN_NGAY_THANH_TOAN_TT = "ngay_thanh_toan_tt";//ngày thanh toán kỳ thực tế
    const COLUMN_STATUS = "status";//trạng thái thông báo
    const COLUMN_STATUS_NOTIFICATION = "status_notification";//trạng thái thông báo
    const COLUMN_NGAY_THANH_TOAN_UNIX = 'ngay_thanh_toan_unix';// convert time ngày thanh toán


    const COLUMN_BLOCK = '1';//chưa thanh toán
    const COLUMN_ACTIVE = '2';//đã thanh toán

    protected $fillable = [
        self::COLUMN_CODE_CONTRACT,
        self::COLUMN_STATUS_NOTIFICATION,
        self::COLUMN_STATUS,
        self::COLUMN_HOP_DONG_SO,
        self::COLUMN_ONE_MONTH_RENT,
        self::COLUMN_NGAY_THANH_TOAN,
        self::COLUMN_NGAY_THANH_TOAN_TT,
    ];
}
