<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class  TradeInventoryReport extends Model
{
    protected $connection = "mongodb";

    protected $collection = "trade_inventory_report";

    protected $primarykey = "_id";

    public $timestamps = false;

    protected $guarded = [];

    const ID = '_id';
    const ITEM = 'item';
    const ITEM_ID = 'id';
    const STORE_ID = 'store_id';
    const CODE = 'code';
    const STORE_NAME = 'store_name';
    const ITEM_AMOUNT = 'amount';
    const DESCRIPTION = 'description';
    const LICENSE = 'license';
    const CREATED_AT = 'created_at';
    const CREATED_BY = 'created_by';
    const UPDATED_AT = 'updated_at';
    const UPDATED_BY = 'updated_by';
    const LOG = 'log';
    const STATUS = 'status';
    const ADJUSTMENT = 'adjustment';
    const EXPLANATION = 'explanation';
    const MIEN_BAC = "MB";
    const MIEN_NAM = "MN";
    const ID_REPORT = 'id_report';
    const NOTE = 'note';
    const FOR_CONTROL = 'for_control';
    const SYSTEM = 'system';
    const DATA  = 'data';
    const DIFF  = 'diff';

    public static $domain = [
        self::MIEN_BAC => 'Miền Bắc',
        self::MIEN_NAM => 'Miền Nam',
    ];

    const DIFF_TRUE = 1;
    const DIFF_FALSE = 0;

    const STATUS_WAIT_FORCONTROL = 1;
    const STATUS_WAIT_EXPLANATION = 2;
    const STATUS_WAIT_ADJUSTMENT = 3;
    const STATUS_WAIT_APPROVED_ADJUSTMENT = 4;
    const STATUS_DONE = 5;

    const STATUS_ADJUSTMENT_DONE = 'done';
    const STATUS_ADJUSTMENT_NEW = 'new';
    const STATUS_ADJUSTMENT_CANCEL = 'cancel';

   public static $status = [
       self::STATUS_WAIT_FORCONTROL => 'Chờ đối soát',
       self::STATUS_WAIT_EXPLANATION => 'Chờ giải trình',
       self::STATUS_WAIT_ADJUSTMENT => 'Chờ điều chỉnh',
       self::STATUS_WAIT_APPROVED_ADJUSTMENT => 'Chờ duyệt điều chỉnh',
       self::STATUS_DONE => 'Hoàn thành',
   ];

    public static $status_adjustment = [
        self::STATUS_ADJUSTMENT_DONE => "Hoàn thành",
        self::STATUS_ADJUSTMENT_NEW => "Chờ duyệt",
        self::STATUS_ADJUSTMENT_CANCEL => "Hủy",
    ];

}
