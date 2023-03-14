<?php


namespace Modules\AssetTienNgay\Model;


class ActionUser extends BaseModel
{
    protected $connection = 'mongodb-asset';
    public $timestamps = FALSE;

    const ID = '_id';
    const USER_ID = 'user_id';
    const ACTIONS = 'actions';

    const ACTIVE = 'active';
    const BLOCK = 'block';

    protected $collection = 'action_user_asset';
}
