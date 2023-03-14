<?php


namespace Modules\AssetLocation\Model;


class LogAlarmContract extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'log_alarm_contract_asset_location';
    public $timestamps = FALSE;
}
