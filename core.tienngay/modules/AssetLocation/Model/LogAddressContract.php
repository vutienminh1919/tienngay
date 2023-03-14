<?php


namespace Modules\AssetLocation\Model;


class LogAddressContract extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'log_address_contract_asset_location';
    public $timestamps = FALSE;
}
