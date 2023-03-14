<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class DeliveryBill extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'delivery_bill';

    protected $primarykey = "_id";

    public $timestamps = false;

    /**
     * Column name table
     */
    const ID = "_id";
    const STORES_ID = "id";
    const CREATED_AT = 'created_at';
    const CREATED_BY = 'created_by';
    const UPDATED_BY = 'updated_by';
    const UPDATED_AT = 'updated_at';
    const STATUS     = 'status'; // trạng thái
    const TYPE_CATEGORY     = 'type_category'; //hạng mục
    const AMOUNT        = 'amount'; // số lượng
    const CATEGORY      = 'category'; // loại ấn phẩm
    const TAGET      = 'taget'; // mục tiêu triển khai
    const NAME          = 'name'; // tên ấn phẩm
    const SPECIFICATION = 'specification'; //quy cách
    const URL           = 'url'; //ảnh ấn phẩm
    const NOTE          = 'note'; //ghi chú
    const STORES          = 'stores'; //pgd
    const LIST           = 'list'; //ds ấn phẩm
    const LICENSE               = 'license'; //Chứng từ
    const LOGS              = "logs";

    const CATEGORY_PUBLICATION = 'publication';
    const CATEGORY_ITEM = 'item';

    const TAGET_GOAL_DIRECT = 'direct';
    const TAGET_GOAL_INDIRECT = 'indirect';

    const STATUS_MISSING = 1;
    const STATUS_COMPLETE= 2;

    protected $guarded = [];

    public static $categories = [
        self::CATEGORY_PUBLICATION => 'Ấn phẩm',
        self::CATEGORY_ITEM => 'Vật phẩm'
    ];

    public static $taget_goal = [
        self::TAGET_GOAL_DIRECT => 'Trực tiếp',
        self::TAGET_GOAL_INDIRECT => 'Phủ nhận diện'
    ];

    public static $status = [
        self::STATUS_MISSING => 'Thiếu chứng từ',
        self::STATUS_COMPLETE => 'Hoàn thành',
    ];
}
