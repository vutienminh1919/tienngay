<?php


namespace Modules\AssetTienNgay\Model;


class WarehouseAsset extends BaseModel
{
    protected $connection = 'mongodb-asset';
    public $timestamps = FALSE;

    const ID = '_id';
    const NAME = 'name';
    const TYPE = 'type';
    const SLUG = 'slug';
    const STATUS = 'status';
    const LEVEL = 'level';
    const PARENT_ID = 'parent_id';

    const ACTIVE = 'active';
    const BLOCK = 'block';

    protected $collection = 'warehouse_asset';
}
