<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class TradeStorage extends Model
{
    protected $connection = "mongodb";

    protected $collection = "trade_storage";

    protected $primarykey = "_id";

    public $timestamps = false;

    protected $guarded = [];

    const ID                    = '_id';
    const ITEMS                 = 'items';
    const CREATED_AT            = 'created_at';
    const CREATED_BY            = 'created_by';
    const UPDATED_AT            = 'updated_at';
    const UPDATED_BY            = 'updated_by';
    const LOGS                  = 'logs';
    const STATUS                = 'status'; // trạng thái
    const TYPE_CATEGORY         = 'type_category'; //hạng mục
    const AMOUNT                = 'amount'; // số lượng
    const CATEGORY              = 'category'; // loại ấn phẩm
    const TAGET                 = 'taget'; // mục tiêu triển khai
    const NAME                  = 'name'; // tên ấn phẩm
    const SPECIFICATION         = 'specification'; //quy cách
    const URL                   = 'url'; //ảnh ấn phẩm
    const NOTE                  = 'note'; //ghi chú
    const STORE_NAME            = 'store_name'; //pgd name
    const STORE_ID              = 'store_id'; //pgd id

    const ITEM_KEY              = 'key';
    const ITEM_ID               = 'item_id';
    const ITEM_CODE             = 'code_item';
    const ITEM_NAME             = 'name'; // tên ấn phẩm
    const ITEM_TYPE             = 'type'; // loại ấn phẩm
    const ITEM_SPECIFICATIONS   = 'specification'; // quy cách đóng gói
    const ITEM_QUANTITY_STOCK   = 'quantity_stock'; // số lượng trong kho
    const ITEM_QUANTITY_BROKEN  = 'quantity_broken'; // số lượng hỏng
    const ITEM_CATEGORY         = 'category'; //danh mục
    const ITEM_TARGET           = 'taget_goal'; // mục tiêu triển khai

    const SYSTEM = 'System';
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        self::CREATED_AT => 'integer',
        self::UPDATED_AT => 'integer'
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
            $model->updated_at = time();
        });

        static::updating(function ($model) {
            $model->updated_at = time();
        });

        static::deleting(function ($model) {
            $model->deleted_at = time();
        });
    }

}
