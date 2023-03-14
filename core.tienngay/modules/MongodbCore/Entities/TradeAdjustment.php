<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class TradeAdjustment extends Model
{
    protected $connection = "mongodb";

    protected $collection = "trade_adjustment_bill";

    protected $primarykey = "_id";

    public $timestamps = false;

    protected $guarded = [];

    const ID = '_id';
    const ITEM = 'item';
    const ITEM_ID = 'id';
    const STORE_ID = 'store_id';
    const STORE_NAME = 'store_name';
    const QUANTITY_BROKEN = 'quantity_broken';
    const QUANTITY_DIFFERENT = 'quantity_different';
    const DESCRIPTION = 'description';
    const LICENSE = 'license';
    const CREATED_AT = 'created_at';
    const CREATED_BY = 'created_by';
    const UPDATED_AT = 'updated_at';
    const UPDATED_BY = 'updated_by';
    const LOG = 'log';
    const STATUS = 'status';


    const STATUS_PENDING = 1;  // trạng thái đang chờ
    const STATUS_DONE = 2;  // trạng thái đã duyệt
    const STATUS_CANCEL = 3;  // trạng thái hủy

    const MIEN_BAC = "MB";
    const MIEN_NAM = "MN";

    public static $status = [
        self::STATUS_PENDING => 'Chờ duyệt',
        self::STATUS_DONE => 'Đã duyệt',
        self::STATUS_CANCEL => 'Hủy'
    ];

    public static $domain = [
        self::MIEN_BAC => 'Miền Bắc',
        self::MIEN_NAM => 'Miền Nam',
    ];

}
