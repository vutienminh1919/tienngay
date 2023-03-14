<?php


namespace Modules\AssetTienNgay\Model;


class EquipmentAsset extends BaseModel
{
    protected $connection = 'mongodb-asset';
    public $timestamps = FALSE;

    const ID = '_id';
    const NAME = 'name';
    const SLUG = 'slug';
    const STATUS = 'status';
    const USERS = 'users';
    const LEVEL = 'level';
    const PARENT_ID = 'parent_id';
    const USER_ID = 'user_id';
    const USER_EMAIL = 'user_email';
    const USER_NAME = 'user_name';

    const ACTIVE = 'active';
    const BLOCK = 'block';
    protected $collection = 'equipment_asset';
}
