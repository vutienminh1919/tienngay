<?php


namespace Modules\MongodbCore\Entities;


use Jenssegers\Mongodb\Eloquent\Model;

class LogAllotment extends Model
{
    protected $connection = "mongodb";

    protected $collection = "logAllotment";

    protected $primarykey = "_id";

    public $timestamps = false;

    protected $guarded = [];

    const ID = "_id";

     const COLUMN_STORE_ID = 'store_id';//id phòng giao dịch
     const COLUMN_STORE_NAME = 'store_name';//tên phòng giao dịch
     const COLUMN_CATEGORY = 'category';//loại ấn phẩm
     const COLUMN_TAGET_GOAL = 'taget_goal';//
     const COLUMN_ITEM_ID = 'item_id';//id mã ấn phẩm
     const COLUMN_CODE_ITEM = 'code_item';//Mã ấn phẩm
     const COLUMN_NAME = 'name';//
     const COLUMN_TYPE = 'type';//
     const COLUMN_SPECIFICATION = 'specification';//
     const COLUMN_QUANTITY_STOCK = 'quantity_stock';//số lượng tồn
     const COLUMN_QUANTITY_IMPORT = 'quantity_import';//số lượng phân bổ

    const CREATED_AT = 'created_at';
    const CREATED_BY = 'created_by';
    const UPDATED_AT = 'updated_at';
    const UPDATED_BY = 'updated_by';


    protected $casts = [
        self::CREATED_AT => 'integer',
        self::UPDATED_AT => 'integer',
    ];


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
    }
}
