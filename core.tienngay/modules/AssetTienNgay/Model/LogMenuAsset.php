<?php


namespace Modules\AssetTienNgay\Model;


class LogMenuAsset extends BaseModel
{
    protected $connection = 'mongodb-asset';
    public $timestamps = FALSE;

    const ID = '_id';
    const REQUEST = 'request';
    const RESPONSE = 'response';
    const TYPE = 'type';

    //type
    const CREATE = 'create';
    const UPDATE = 'update';

    protected $collection = 'log_menu_asset';
}
