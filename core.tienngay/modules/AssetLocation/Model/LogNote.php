<?php


namespace Modules\AssetLocation\Model;


class LogNote extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'log_note_asset_location';
    public $timestamps = FALSE;
}
