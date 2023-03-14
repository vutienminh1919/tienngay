<?php


namespace Modules\AssetLocation\Model;


class LogWarehouseAsset extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'log_warehouse_asset_location';
    public $timestamps = FALSE;

    //type
    const NHAP_KHO_MOI = 1;
    const XUAT_BAN_GIAO_MOI = 2;
    const XUAT_BAN_GIAO_CU = 3;
    const DIEU_CHUYEN_KHO_XUAT = 4;
    const DIEU_CHUYEN_KHO_NHAP = 5;
    const THU_HOI_VE_KHO = 6;
    const NHAP_KHO_CU = 7;
}
