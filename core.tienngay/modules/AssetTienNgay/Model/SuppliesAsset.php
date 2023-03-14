<?php


namespace Modules\AssetTienNgay\Model;


class SuppliesAsset extends BaseModel
{
    protected $connection = 'mongodb-asset';
    public $timestamps = FALSE;

    const ID = '_id';
    const NAME = 'name';
    const SLUG = 'slug';
    const CODE = 'code';
    const PRICE = 'price';
    const SLUG_SUPPLIER = 'slug_supplier';
    const SUPPLIER = 'supplier';
    const STATUS = 'status';
    const PURCHASE_DATE = 'purchase_date';
    const DESCRIPTION = 'description';
    const IMAGE_AVATAR_ASSET = 'image_avatar_asset';
    const IMAGE_ASSET = 'image_asset';
    const WARRANTY_PERIOD = 'warranty_period';
    const WAREHOUSE_ID = 'warehouse_id';
    const EQUIPMENT_ID = 'equipment_id';
    const EQUIPMENT_CHILD_ID = 'equipment_child_id';
    const DEPARTMENT_ID = 'department_id';
    const USER_ID = 'user_id';
    const TYPE_SUPPLIES = 'type_supplies';
    const DATE_RECEIVE = 'date_receive';
    const DATE_STORAGE = 'date_storage';
    const RECEPTION_STAFF = 'reception_staff';
    const STATUS_REQUEST = 'status_request';
    const INVENTORY_DATE = 'inventory_date';
    const STATUS_RECEIVE = 'status_receive';
    const DATE_STATUS_RECEIVE = 'date_status_receive';
    const FLAG = 'flag';

    const THIET_BI_MOI = 1;
    const THIET_BI_HONG = 2;
    const THIET_BI_LUU_KHO = 3;
    const THIET_BI_DANG_SU_DUNG = 4;
    const THIET_BI_CHO_XU_LY = 5;

    const ACTIVE = 'active';
    const BLOCK = 'block';

    const IMAGE_LOGO = "https://service.tienngay.vn/uploads/avatar/1637677417-2574ba54b0443515f512246c5ff7775b.png";
    protected $collection = 'supplies_asset';

}
