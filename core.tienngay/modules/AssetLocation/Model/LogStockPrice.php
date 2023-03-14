<?php


namespace Modules\AssetLocation\Model;


class LogStockPrice extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'log_stock_asset_location';
    public $timestamps = FALSE;
}
