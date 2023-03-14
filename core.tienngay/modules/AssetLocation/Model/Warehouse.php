<?php


namespace Modules\AssetLocation\Model;


class Warehouse extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'warehouse_asset_location';
    public $timestamps = FALSE;

    //column
    const NAME = 'name';
    const SLUG = 'slug';
    const STATUS = 'status';
    const STORE_ID = 'store_id';
    const AREA = 'area';
    const PHONE_REPRESENTATIVE = 'phone_representative';
    const LEVEL = 'level';
    const TYPE = 'type';

    //status
    const ACTIVE = 'active';
    const BLOCK = 'block';

    //type
    const TAX = 'tax';
    const LOCAL = 'local';
}
