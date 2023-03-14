<?php


namespace Modules\AssetTienNgay\Model;


class ActionAsset extends BaseModel
{
    protected $connection = 'mongodb-asset';
    public $timestamps = FALSE;

    const ID = '_id';
    const NAME = 'name';
    const SLUG = 'slug';
    const STATUS = 'status';

    const ACTIVE = 'active';
    const BLOCK = 'block';

    protected $collection = 'action_asset';
}
