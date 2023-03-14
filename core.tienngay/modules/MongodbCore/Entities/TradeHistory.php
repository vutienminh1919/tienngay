<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class TradeHistory extends Model
{
    protected $connection = "mongodb";

    protected $collection = "trade_history";

    protected $primarykey = "_id";

    public $timestamps = false;

    protected $guarded = [];

    const ID = '_id';
    const CODE_ITEM = 'code_item';
    const ITEM_ID = 'item_id';
    const CATEGORY = 'category';
    const TAGET_GOAL = 'taget_goal';
    const NAME = 'name';
    const TYPE = 'type';
    const SPECIFICATION = 'specification';
    const STORE_NAME = "store_name";
    const STORE_ID = "store_id";
    const AMOUNT = 'amount';
    const QUANTITY_IMPORT = 'quantity_import';
    const QUANTITY_EXPORT = 'quantity_export';
    const QUANTITY_BROKEN = 'quantity_broken';
    const QUANTITY_OLD = 'quantity_old';
    const QUANTITY_STOCK = 'quantity_stock';
    const ACTION = 'action';
    const ITEMS = 'items';
    const NCC   = 'ncc';
    const ACTUAL_PRICE   = 'actual_price';
    const TYPE_REPORT = "type_report";
    const IS_CONFIRMED = "is_confirmed";
    const ID_TRANSFER = "id_transfer";

    const CREATED_AT = 'created_at';
    const CREATED_BY = 'created_by';
    const UPDATED_AT = 'updated_at';
    const UPDATED_BY = 'updated_by';

    const ACTION_BUY = 1;
    const ACTION_DELIVERY = 2;
    const ACTION_TRANSFER = 3;
    const ACTION_ADJUST = 4;
    const ACTION_OLD = 5;

    const SYSTEM = 'System';

    const EXPORT = "export";
    const IMPORT = "import";
    const CANCEL = "cancel";

    const CONFIRMED = 1;
    const NOT_CONFIRMED = 2;

    public static $transactionType = [
        self::ACTION_BUY => "Nhập mua",
        self::ACTION_DELIVERY => "Xuất dùng",
        self::ACTION_TRANSFER => "Điều chuyển",
        self::ACTION_ADJUST => "Điều chỉnh",
        self::ACTION_OLD => "Cũ/Hỏng",
    ];

    /**
     * handle event
     *
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = time();
        });
        static::updating(function ($model) {
            $model->updated_at = time();
        });
        static::deleting(function ($model) {
            $model->deleted_at = time();
        });
    }

}
