<?php


namespace Modules\AssetLocation\Model;


class LogLocationAsset extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'log_location_asset_location';
    public $timestamps = FALSE;
}
