<?php


namespace Modules\AssetLocation\Model;


class LogAlarm extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'log_alarm_asset_location';
    public $timestamps = FALSE;
}
