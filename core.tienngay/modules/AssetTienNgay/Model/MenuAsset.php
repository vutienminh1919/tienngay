<?php


namespace Modules\AssetTienNgay\Model;


class MenuAsset extends BaseModel
{
    protected $connection = 'mongodb-asset';
    public $timestamps = FALSE;

    const ID = '_id';
    const NAME = 'name';
    const URL = 'url';
    const SLUG = 'slug';
    const PARENT_ID = 'parent_id';
    const STATUS = 'status';
    const ICON = 'icon';
    const USER_ID = 'user_id';
    const USER_EMAIL = 'user_email';
    const LEVEL = 'level';
    const DEPART_ID = 'depart_id';
    const EQUIP_ID = 'equip_id';
    const EQUIP_CHILD_ID = 'equip_child_id';
    const TYPE = 'type';
    const USER_NAME = 'user_name';
    const SIGN = 'sign';

    const ACTIVE = 'active';
    const BLOCK = 'block';

    const TYPE_HOI_SO = 'HO';
    const TYPE_PHONG_GIAO_DICH = 'PGD';
    const TYPE_THIET_BI = 'DEVICE';
    const TYPE_MENU = 'MENU';
    const TYPE_KHO_LUU_TRU = 'KHO';
    protected $collection = 'menu_asset';
}
