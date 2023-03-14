<?php


namespace Modules\AssetLocation\Model;


class GroupRole extends BaseMongoModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'group_role';
    public $timestamps = FALSE;
}
