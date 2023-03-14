<?php


namespace Modules\AssetLocation\Model;


class LogDeviceContract extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'log_device_contract_asset_location';
    public $timestamps = FALSE;
}
