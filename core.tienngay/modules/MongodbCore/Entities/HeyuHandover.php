<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class HeyuHandover extends Model
{
    protected $connection = "mongodb";

    protected $collection = "heyu_handover";

    protected $primarykey = "_id";

    protected $guarded = [];

    public $timestamps = false;

    const ID                    = '_id'; // primary key
    const STORE_ID              = 'store_id'; // id PGD
    const STORE_NAME            = 'store_name'; // tên PGD
    const DRIVER_CODE           = 'driver_code'; // mã tài xế
    const DRIVER_NAME           = 'driver_name'; // tên tài xế
    const COAT                  = 'coat'; // áo khoác
    const HELMET                = 'helmet'; // mũ bảo hiểm
    const SHIRT                 = 'shirt'; // áo phông
    const DELIVERY_DATE         = 'delivery_date'; // Ngày giao đồng phục
    const STATUS                = 'status';
    const APPROVE_BY            = 'approved_by';
    const APPROVE_AT            = 'approved_at';
    const CANCLE_NOTE           = 'cancel_note';
    const EVIDENCE              = 'evidence';

    const CREATED_AT            = 'created_at';
    const CREATED_BY            = 'created_by';
    const UPDATED_AT            = 'updated_at';
    const UPDATED_BY            = 'updated_by';

    //size ao khoac + ao phong
    const SIZE_S                = 's'; // size s
    const SIZE_M                = 'm'; // size m
    const SIZE_L                = 'l'; // size l
    const SIZE_XL               = 'xl'; // size xl
    const SIZE_XXL              = 'xxl'; // size xxl
    const SIZE_XXXL             = 'xxxl'; // size xxxl

    const STATUS_WAIT_APPROVE   = 1; // trạng thái chờ duyệt
    const STATUS_APPROVED       = 2; // trạng thái đã duyệt
    const STATUS_CANCLED        = 3; // trạng thái đã hủy

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        self::STATUS => 'integer',
        self::DELIVERY_DATE => 'integer',
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
            $model->status = self::STATUS_WAIT_APPROVE;
            $model->cancel_note = "";
            $model->created_at = time();
            $model->updated_at = time();
            $model->delivery_date = time();
        });
        static::updating(function ($model) {
            $model->updated_at = time();
        });
    }
}
