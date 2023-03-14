<?php


namespace Modules\AssetTienNgay\Model;


class DeviceAsset extends BaseModel
{
    protected $connection = 'mongodb-asset';
    public $timestamps = FALSE;

    const ID = '_id';
    const USER_ID = 'user_id';
    const DEVICE = 'device';

    protected $collection = 'device_asset';
}
