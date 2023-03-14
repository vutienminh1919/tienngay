<?php


namespace Modules\AssetTienNgay\Model;


class CodeAsset extends BaseModel
{
    protected $connection = 'mongodb-asset';
    public $timestamps = FALSE;

    const ID = '_id';
    const DEPARTMENT_ID = 'department_id';
    const EQUIPMENT_CHILD_ID = 'equipment_child_id';
    const COUNT = 'count';

    protected $collection = 'code_asset';
}
