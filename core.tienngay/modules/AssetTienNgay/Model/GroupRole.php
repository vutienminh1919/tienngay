<?php


namespace Modules\AssetTienNgay\Model;


class GroupRole extends BaseModel
{
    protected $connection = 'mongodb-asset';
    protected $collection = 'group_role';
    public $timestamps = FALSE;
}
