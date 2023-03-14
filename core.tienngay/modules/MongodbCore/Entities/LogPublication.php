<?php


namespace Modules\MongodbCore\Entities;


use Jenssegers\Mongodb\Eloquent\Model;

class LogPublication extends Model
{
    protected $connection = "mongodb";

    protected $collection = "logPublication";

    protected $primarykey = "_id";

    public $timestamps = false;

    protected $guarded = [];

    const ID = "_id";
    const COLUMN_CONTRACT_ID = "contract_id";

    //thông tin chung
    const COLUMN_SUPPLIER = 'supplier';//nhà cung cấp ấn phẩm
    const COLUMN_OTHER_COTS = 'other_costs';//chi phí khác
    const COLUMN_DATE_ACCEPTANCE = 'date_acceptance';//ngày nghiệm thu

    //thông tin ấn phẩm
    const COLUMN_ITEM_ID = 'item_id';//mã ấn phẩm
    const COLUMN_TOTAL = 'total';//số lượng ấn phẩm
    const COLUMN_IMAGE_DETAIL = 'image_detail';//ảnh mô tả ấn phẩm
    const COLUMN_IMAGE_ACCEPTION = 'image_acception';//ảnh nghiệm thu

    //mô tả ấn phẩm
    const COLUMN_NAME_PUBLICATIONS = 'name_publications';//tên ấn phẩm
    const COLUMN_TECH = 'tech';//quy cách ấn phẩm
    const COLUMN_MATERIAL = 'material';//quy cách ấn phẩm
    const COLUMN_SIZE = 'size';//quy cách ấn phẩm
    const COLUMN_TYPE = 'type';//loại ấn phẩm
    const COLUMN_MONEY_PUBLICATIONS = 'money_publications';//chi phí thực tế

    const CREATED_AT = 'created_at';
    const CREATED_BY = 'created_by';
    const UPDATED_AT = 'updated_at';
    const UPDATED_BY = 'updated_by';

    const COLUMN_LEAD_PUBLICATIONS = 'lead_publications';//danh sách ấn phẩm
    const COLUMN_KEY_ID = 'key_id';
    const COLUMN_TOTAL_ACCEPTANCE = 'total_acceptance';//số lượng nghiệm thu
    const COLUMN_STATUS = 'status';

    const STATUS_NEW = 'status_new';//new , trạng thái mới
    const STATUS_OLD = 'status_old';//old , trạng thái cũ


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
