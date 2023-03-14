<?php


namespace Modules\AssetLocation\Model;


class Report extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'report_asset_location';
    public $timestamps = FALSE;
}
