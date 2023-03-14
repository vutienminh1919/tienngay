<?php


namespace Modules\AssetLocation\Model;


class LogDevice extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'log_device_asset_location';
    public $timestamps = FALSE;

    //column
    const OLD = 'old';
    const NEW = 'new';
    const TYPE = 'type';
    const DEVICE_ASSET_LOCATION_ID = 'device_asset_location_id';

    //type
    const NEW_IMPORT = 'new_import';
    const TRANSFER = 'transfer';
    const RECALL = 'recall';
    const OLD_IMPORT = 'old_import';
    const UPDATE_STOCK = 'update_stock';
}

