<?php


namespace Modules\AssetTienNgay\Model;


class RoleAsset extends BaseModel
{
    protected $connection = 'mongodb-asset';
    public $timestamps = FALSE;

    const ID = '_id';
    const NAME = 'name';
    const SLUG = 'slug';
    const STATUS = 'status';
    const USERS = 'users';
    const MENUS = 'menus';
    const ACCESS_RIGHTS = 'access_rights';
    const TYPE = 'type';

    const ACTIVE = 'active';
    const BLOCK = 'block';

    protected $collection = 'role_asset';
}
