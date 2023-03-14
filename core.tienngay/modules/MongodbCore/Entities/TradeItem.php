<?php

namespace Modules\MongodbCore\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class TradeItem extends Model
{
    protected $connection = "mongodb";

    protected $collection = "trade_item";

    protected $primarykey = "_id";

    public $timestamps = false;

    protected $guarded = [];

    const ID = "_id";
    const ITEM_ID = "item_id";
    const CATEGORY = "category";
    const SPECIFICATION = "specification";
    const TARGET_GOAL = "target_goal";
    const MOTIVATING_GOAL = "motivating_goal";
    const NAME = "name";
    const SLUG_NAME = "slug_name";
    const TYPE = "type";
    const PRICE = "price";
    const SIZE = "size";
    const MATERIAL = "material";
    const TECH = "tech";
    const STORE = "store";
    const STORE_NAME = "name";
    const STORE_ID = "id";
    const STATUS = "status";
    const CREATED_AT = "created_at";
    const CREATED_BY = "created_by";
    const UPDATED_AT = "updated_at";
    const UPDATED_BY = "updated_by";
    const DETAIL = "detail";
    const IMAGE = "path";
    const LOG = "log";
    const DATE = "date";

    const STATUS_ACTIVE = 1;
    const STATUS_BLOCK = 2;

    const DKXM = 'Đăng ký xe máy';
    const DKOTO = "Đăng ký ô tô";
    const OTHER = 'Khác';

    const ITEM = "Vật phẩm";
    const PUBLICATION = "Ấn phẩm";

    const DIRECT = "Trực tiếp";
    const INDIRECT = "Phủ nhận diện";

    public static $motivating_goal = [
        'DKXM' => 'Đăng ký xe máy',
        'DKOTO' => "Đăng ký ô tô",
        'other' => 'Khác',
    ];

    public static $category = [
        'item' => "Vật phẩm",
        'publication' => "Ấn phẩm",
    ];

    public static $target_goal = [
        'direct ' => "Trực tiếp",
        'indirect' => "Phủ nhận diện",

    ];



}
